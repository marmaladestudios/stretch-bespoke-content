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

# Start MySQL in background
echo "Starting MySQL..."
mysqld --user=mysql --datadir=/data/mysql --socket=/run/mysqld/mysqld.sock --port=3306 &

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
for i in $(seq 1 60); do
    if mysqladmin ping --socket=/run/mysqld/mysqld.sock --silent 2>/dev/null; then
        echo "MySQL is ready."
        break
    fi
    if [ $i -eq 60 ]; then
        echo "MySQL failed to start."
        exit 1
    fi
    sleep 1
done

# ── Root authentication probe (AUD-017) ──
# Fresh installs authenticate root passwordless over the socket (unix_socket auth);
# once MYSQL_ROOT_PASSWORD has been applied it also works with the password.
MYSQL_ROOT_ARGS=(--socket=/run/mysqld/mysqld.sock -u root)
if ! mysqladmin "${MYSQL_ROOT_ARGS[@]}" status >/dev/null 2>&1; then
    if [ -n "${MYSQL_ROOT_PASSWORD}" ] && mysqladmin "${MYSQL_ROOT_ARGS[@]}" -p"${MYSQL_ROOT_PASSWORD}" status >/dev/null 2>&1; then
        MYSQL_ROOT_ARGS+=(-p"${MYSQL_ROOT_PASSWORD}")
    else
        echo "ERROR: unable to authenticate to MySQL as root."
        exit 1
    fi
fi

# Create WordPress database and user. ALTER USER keeps the app user's password in
# sync with WORDPRESS_DB_PASSWORD even when the user already exists (migration
# from the old hardcoded 'wordpress' password to a Render-generated secret).
mysql "${MYSQL_ROOT_ARGS[@]}" <<-EOSQL
    CREATE DATABASE IF NOT EXISTS wordpress;
    CREATE USER IF NOT EXISTS 'wordpress'@'localhost' IDENTIFIED BY '${WORDPRESS_DB_PASSWORD}';
    ALTER USER 'wordpress'@'localhost' IDENTIFIED BY '${WORDPRESS_DB_PASSWORD}';
    GRANT ALL PRIVILEGES ON wordpress.* TO 'wordpress'@'localhost';
    FLUSH PRIVILEGES;
EOSQL
echo "Database ready."

# Apply the root password when configured (idempotent). The entrypoint itself keeps
# access via unix_socket auth as the root OS user, so this cannot lock us out.
if [ -n "${MYSQL_ROOT_PASSWORD}" ]; then
    mysql "${MYSQL_ROOT_ARGS[@]}" -e "ALTER USER 'root'@'localhost' IDENTIFIED BY '${MYSQL_ROOT_PASSWORD}'; FLUSH PRIVILEGES;" \
        || echo "Warning: could not set MySQL root password (continuing)."
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
