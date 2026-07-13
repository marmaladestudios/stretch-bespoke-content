#!/bin/bash
set -e

# ── Persistent storage setup ──
mkdir -p /data/mysql
mkdir -p /data/uploads

# Symlink MySQL data directory
if [ ! -L /var/lib/mysql ] || [ "$(readlink /var/lib/mysql)" != "/data/mysql" ]; then
    rm -rf /var/lib/mysql
    ln -sf /data/mysql /var/lib/mysql
fi
chown -R mysql:mysql /data/mysql

# Symlink WordPress uploads
mkdir -p /var/www/html/wp-content
if [ ! -L /var/www/html/wp-content/uploads ] || [ "$(readlink /var/www/html/wp-content/uploads)" != "/data/uploads" ]; then
    rm -rf /var/www/html/wp-content/uploads
    ln -sf /data/uploads /var/www/html/wp-content/uploads
fi
chown -R www-data:www-data /data/uploads

# ── Database credentials (AUD-017) ──
# In production these come from Render env vars (generateValue in render.yaml).
# Fall back to the historical local-dev values when absent so local runs keep working.
WORDPRESS_DB_PASSWORD="${WORDPRESS_DB_PASSWORD:-wordpress}"
MYSQL_ROOT_PASSWORD="${MYSQL_ROOT_PASSWORD:-}"

# ── Initialize MySQL if empty ──
if [ ! -d "/data/mysql/mysql" ]; then
    echo "Initializing MySQL data directory..."
    mysql_install_db --user=mysql --datadir=/data/mysql
fi

# Ensure socket directory exists
mkdir -p /run/mysqld
chown mysql:mysql /run/mysqld

# ── Survivability boundary ─────────────────────────────────────────────
# Everything below must NEVER kill PID 1: a failed seed, auth mismatch, or a
# slow InnoDB crash-recovery should degrade the site, not crash-loop the
# container (learned the hard way in production — repeated OOM kills left
# recovery slower than the old 60s timeout, and `set -e` turned every hiccup
# into a restart storm).
set +e

# Start MySQL in background
echo "Starting MySQL..."
mysqld --user=mysql --datadir=/data/mysql --socket=/run/mysqld/mysqld.sock --port=3306 &

# Wait for MySQL to be ready — InnoDB crash recovery after an unclean shutdown
# can take minutes; give it 180s, then one restart attempt, then proceed
# regardless (Apache will serve a DB-error page, but the container stays alive
# and the next health cycle retries instead of hard-looping).
wait_for_mysql() {
    local budget=$1
    for i in $(seq 1 "$budget"); do
        if mysqladmin ping --socket=/run/mysqld/mysqld.sock --silent 2>/dev/null; then
            return 0
        fi
        sleep 1
    done
    return 1
}
echo "Waiting for MySQL to be ready (up to 180s)..."
if wait_for_mysql 180; then
    echo "MySQL is ready."
else
    echo "WARNING: MySQL not ready after 180s — restarting mysqld once..."
    mysqld --user=mysql --datadir=/data/mysql --socket=/run/mysqld/mysqld.sock --port=3306 &
    if wait_for_mysql 120; then
        echo "MySQL is ready after restart."
    else
        echo "ERROR: MySQL still not ready — continuing so the container stays alive for inspection."
    fi
fi

# ── Root authentication + credential self-heal (AUD-017) ──
# root authenticates passwordless over the local socket. We deliberately DO NOT
# set a root password: the socket is localhost-only (never network-exposed), and
# keeping root reachable over it means the entrypoint can ALWAYS resync the app
# user's password. Setting a root password from a Render-generated env value is
# what took production down — when that value drifted from the password stored on
# the persistent MySQL disk, root auth failed, the app-user resync was skipped,
# and WordPress could no longer connect (500 "Error establishing a database
# connection"). Root-over-socket + always-resync makes that lockout unrecoverable
# state impossible.
MYSQL_ROOT_ARGS=(--socket=/run/mysqld/mysqld.sock -u root)
MYSQL_ROOT_OK=0
if mysqladmin "${MYSQL_ROOT_ARGS[@]}" status >/dev/null 2>&1; then
    MYSQL_ROOT_OK=1
elif [ -n "${MYSQL_ROOT_PASSWORD}" ] && mysqladmin "${MYSQL_ROOT_ARGS[@]}" -p"${MYSQL_ROOT_PASSWORD}" status >/dev/null 2>&1; then
    MYSQL_ROOT_ARGS+=(-p"${MYSQL_ROOT_PASSWORD}")
    MYSQL_ROOT_OK=1
fi

# Self-heal: if root auth failed, the disk holds a root password we can't
# reproduce. Reset credentials via mysqld --init-file (runs the SQL as superuser
# at startup, before the grant tables gate connections — the textbook, no
# auth-bypass-window way to reset MySQL/MariaDB passwords). Passwords come from
# this boot's variables, so WordPress and MySQL are guaranteed consistent after.
if [ "${MYSQL_ROOT_OK}" -eq 0 ]; then
    echo "WARNING: root auth failed — self-healing MySQL credentials via --init-file..."
    RESET_SQL=/run/mysqld/reset-credentials.sql
    cat > "${RESET_SQL}" <<-EOSQL
	ALTER USER 'root'@'localhost' IDENTIFIED BY '';
	CREATE DATABASE IF NOT EXISTS wordpress;
	CREATE USER IF NOT EXISTS 'wordpress'@'localhost' IDENTIFIED BY '${WORDPRESS_DB_PASSWORD}';
	ALTER USER 'wordpress'@'localhost' IDENTIFIED BY '${WORDPRESS_DB_PASSWORD}';
	GRANT ALL PRIVILEGES ON wordpress.* TO 'wordpress'@'localhost';
	FLUSH PRIVILEGES;
	EOSQL
    chown mysql:mysql "${RESET_SQL}" 2>/dev/null || true
    # Stop the running mysqld (root auth is broken, so no graceful mysqladmin).
    pkill -x mysqld 2>/dev/null || kill "$(pidof mysqld)" 2>/dev/null || true
    for i in $(seq 1 30); do mysqladmin ping --socket=/run/mysqld/mysqld.sock --silent 2>/dev/null || break; sleep 1; done
    # Restart with the reset init-file applied.
    mysqld --user=mysql --datadir=/data/mysql --socket=/run/mysqld/mysqld.sock --port=3306 --init-file="${RESET_SQL}" &
    if wait_for_mysql 180; then
        echo "MySQL credentials reset — root now reachable over socket."
        MYSQL_ROOT_ARGS=(--socket=/run/mysqld/mysqld.sock -u root)
        MYSQL_ROOT_OK=1
    else
        echo "ERROR: MySQL did not come back after credential reset — container stays alive for inspection."
    fi
    rm -f "${RESET_SQL}" 2>/dev/null || true
fi

if [ "${MYSQL_ROOT_OK}" -eq 1 ]; then
    # Create the DB + app user and keep the app-user password in sync with
    # WORDPRESS_DB_PASSWORD (the value WordPress itself uses this boot).
    mysql "${MYSQL_ROOT_ARGS[@]}" <<-EOSQL || echo "WARNING: DB/user sync failed (continuing)."
	CREATE DATABASE IF NOT EXISTS wordpress;
	CREATE USER IF NOT EXISTS 'wordpress'@'localhost' IDENTIFIED BY '${WORDPRESS_DB_PASSWORD}';
	ALTER USER 'wordpress'@'localhost' IDENTIFIED BY '${WORDPRESS_DB_PASSWORD}';
	GRANT ALL PRIVILEGES ON wordpress.* TO 'wordpress'@'localhost';
	FLUSH PRIVILEGES;
	EOSQL
    echo "Database ready."

    # Ensure root has NO password so future boots always get in over the socket
    # (clears any lingering password from an older AUD-017 build). Non-fatal.
    mysql "${MYSQL_ROOT_ARGS[@]}" -e "ALTER USER 'root'@'localhost' IDENTIFIED BY ''; FLUSH PRIVILEGES;" 2>/dev/null \
        && MYSQL_ROOT_ARGS=(--socket=/run/mysqld/mysqld.sock -u root) \
        || echo "Note: could not clear root password (continuing)."
fi

# Set WordPress environment (the official image's wp-config.php reads these via
# getenv_docker at request time, so Apache/PHP and WP-CLI both pick them up)
export WORDPRESS_DB_HOST="localhost:/run/mysqld/mysqld.sock"
export WORDPRESS_DB_USER="wordpress"
export WORDPRESS_DB_PASSWORD="${WORDPRESS_DB_PASSWORD}"
export WORDPRESS_DB_NAME="wordpress"

# Run WordPress entrypoint to set up wp-config.php and copy core files
docker-entrypoint.sh apache2-foreground &
WP_PID=$!

# Wait for WordPress files to be in place
echo "Waiting for WordPress to initialize files..."
for i in $(seq 1 30); do
    if [ -f /var/www/html/wp-includes/version.php ]; then
        echo "WordPress files ready."
        break
    fi
    sleep 1
done
sleep 2

# Copy theme from /opt/ staging into the live WordPress install.
# AUD-033: -T treats the destination as the directory itself (the old
# `cp -rf src/ dest/` nested a stretch-theme/stretch-theme copy on restarts
# because cp copies INTO an existing directory).
echo "Installing Stretch Creative theme..."
if [ -d /opt/stretch-theme ]; then
    # Defensive: remove a nested duplicate left behind by the old copy bug.
    rm -rf /var/www/html/wp-content/themes/stretch-theme/stretch-theme
    cp -rT /opt/stretch-theme /var/www/html/wp-content/themes/stretch-theme
    chown -R www-data:www-data /var/www/html/wp-content/themes/stretch-theme
    echo "Theme installed successfully."
else
    echo "ERROR: Theme not found at /opt/stretch-theme/"
fi

# AUD-022: setup scripts are NOT copied into the webroot anymore — they run from
# /opt via `wp eval-file` below. Remove copies left by previously-deployed containers.
rm -f /var/www/html/setup-*.php /var/www/html/content-fixes.php

# Publish static demo bundles alongside WordPress. Existing directories are
# overwritten so git-backed demos update cleanly on each Render deploy.
if [ -d /opt/static-sites ]; then
    echo "Installing static site bundles..."
    cp -rf /opt/static-sites/. /var/www/html/
    chown -R www-data:www-data /var/www/html/bce 2>/dev/null || true
    echo "Static site bundles installed."
fi

# Wait for WordPress to be installed (wp-cli core is-installed will succeed once
# wp-config.php exists AND the install has been completed via the WP installer).
echo "Waiting for WordPress core to be installed before running idempotent setup..."
for i in $(seq 1 60); do
    if wp --allow-root --path=/var/www/html core is-installed 2>/dev/null; then
        echo "WordPress is installed."
        break
    fi
    sleep 2
done

# ── Idempotent seed scripts (AUD-022: run from /opt; AUD-033: version-gated) ──
# The block is skipped when the recorded stretch_seed_version option matches the
# hash of the bundled seed scripts, i.e. it runs once per deploy that actually
# changes a seed script instead of on every container boot.
SEED_SCRIPTS=(
    /opt/setup-services.php
    /opt/setup-team-photos.php
    /opt/setup-portfolio.php
    /opt/content-fixes.php
    /opt/setup-industries.php
    /opt/setup-seo.php
    /opt/sideload-old-domain-images.php
    /opt/setup-page-images.php
    /opt/setup-menus.php
)
SEED_VERSION="$(cat "${SEED_SCRIPTS[@]}" 2>/dev/null | sha256sum | awk '{print $1}')"

if wp --allow-root --path=/var/www/html core is-installed 2>/dev/null; then
    # SEO plugin (AUD-003): install once from wp.org, keep active thereafter
    if ! wp --allow-root --path=/var/www/html plugin is-installed seo-by-rank-math 2>/dev/null; then
        wp --allow-root --path=/var/www/html plugin install seo-by-rank-math --activate 2>&1 \
            || echo "  ! seo-by-rank-math install failed (continuing)"
    else
        wp --allow-root --path=/var/www/html plugin activate seo-by-rank-math >/dev/null 2>&1 || true
    fi

    # Page cache (AUD-012): plugin, advanced-cache.php, and wp-cache-config.php all
    # live in the EPHEMERAL webroot — a deploy wipes them and the site silently runs
    # uncached. Reinstall + restore settings on every boot (cheap no-op when present).
    if ! wp --allow-root --path=/var/www/html plugin is-installed wp-super-cache 2>/dev/null; then
        wp --allow-root --path=/var/www/html plugin install wp-super-cache --activate 2>&1 \
            || echo "  ! wp-super-cache install failed (continuing)"
    else
        wp --allow-root --path=/var/www/html plugin activate wp-super-cache >/dev/null 2>&1 || true
    fi
    wp --allow-root --path=/var/www/html eval '
        if ( ! function_exists( "wp_cache_enable" ) && defined( "WP_PLUGIN_DIR" ) ) {
            @include_once WP_PLUGIN_DIR . "/wp-super-cache/wp-cache.php";
        }
        if ( function_exists( "wp_cache_enable" ) ) {
            if ( function_exists( "wp_cache_verify_config_file" ) ) { wp_cache_verify_config_file(); }
            if ( function_exists( "wp_cache_create_advanced_cache" ) ) { wp_cache_create_advanced_cache(); }
            wp_cache_enable();
            wp_cache_setting( "super_cache_enabled", 1 );
            wp_cache_setting( "wp_cache_mod_rewrite", 0 );
            wp_cache_setting( "wp_cache_not_logged_in", 2 );
            wp_cache_setting( "wp_cache_no_cache_for_get", 1 );
            wp_cache_setting( "cache_max_time", 1800 );
            wp_cache_setting( "cache_time_interval", 600 );
            wp_cache_setting( "cache_rejected_uri", array( "wp-.*\\.php", "index\\.php", "wp-json" ) );
            echo "wp-super-cache config restored\n";
        } else {
            echo "wp-super-cache functions unavailable — skipped\n";
        }
    ' 2>&1 || echo "  ! wp-super-cache config restore failed (continuing)"
    chown -R www-data:www-data \
        /var/www/html/wp-content/plugins/wp-super-cache \
        /var/www/html/wp-content/cache \
        /var/www/html/wp-content/wp-cache-config.php \
        /var/www/html/wp-content/advanced-cache.php 2>/dev/null || true

    # AUD-042: keep the large hub option out of autoload on every environment
    wp --allow-root --path=/var/www/html option set-autoload stretch_hub_aeo off >/dev/null 2>&1 || true

    CURRENT_SEED="$(wp --allow-root --path=/var/www/html option get stretch_seed_version 2>/dev/null || true)"
    if [ -n "${SEED_VERSION}" ] && [ "${CURRENT_SEED}" = "${SEED_VERSION}" ]; then
        echo "Seed scripts unchanged (stretch_seed_version matches) — skipping idempotent setup."
    else
        echo "Running idempotent setup scripts (seed version ${SEED_VERSION})..."
        SEED_OK=1
        for seed_script in "${SEED_SCRIPTS[@]}"; do
            if ! wp --allow-root --path=/var/www/html eval-file "${seed_script}" 2>&1; then
                echo "  ! $(basename "${seed_script}") failed (continuing)"
                SEED_OK=0
            fi
        done
        if [ "${SEED_OK}" -eq 1 ]; then
            wp --allow-root --path=/var/www/html option update stretch_seed_version "${SEED_VERSION}" >/dev/null 2>&1 \
                && echo "Idempotent setup complete — recorded stretch_seed_version." \
                || echo "Idempotent setup complete, but failed to record stretch_seed_version (will re-run next boot)."
        else
            echo "Idempotent setup finished with failures — not recording version; will retry on next boot."
        fi
    fi
else
    echo "WordPress not installed yet — skipping idempotent setup. Run scripts manually after install."
fi

echo "Setup complete. Waiting for Apache..."

# Wait for Apache process
wait $WP_PID
