#!/bin/bash
set -e

# ── Persistent storage setup ──
# /data is the Render persistent disk. We store both MySQL and uploads there.
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

# Create WordPress database and user
mysql --socket=/run/mysqld/mysqld.sock -u root <<-EOSQL
    CREATE DATABASE IF NOT EXISTS wordpress;
    CREATE USER IF NOT EXISTS 'wordpress'@'localhost' IDENTIFIED BY 'wordpress';
    GRANT ALL PRIVILEGES ON wordpress.* TO 'wordpress'@'localhost';
    FLUSH PRIVILEGES;
EOSQL
echo "Database ready."

# Set WordPress environment
export WORDPRESS_DB_HOST="localhost:/run/mysqld/mysqld.sock"
export WORDPRESS_DB_USER="wordpress"
export WORDPRESS_DB_PASSWORD="wordpress"
export WORDPRESS_DB_NAME="wordpress"

# Let WordPress entrypoint handle wp-config.php and start Apache
exec docker-entrypoint.sh apache2-foreground
