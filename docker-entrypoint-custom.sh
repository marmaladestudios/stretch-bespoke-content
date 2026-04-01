#!/bin/bash
set -e

# Initialize MySQL data directory if empty (first run on fresh disk)
if [ ! -d "/var/lib/mysql/mysql" ]; then
    echo "Initializing MySQL data directory..."
    mysql_install_db --user=mysql --datadir=/var/lib/mysql
fi

# Ensure socket directory exists
mkdir -p /run/mysqld
chown mysql:mysql /run/mysqld

# Start MySQL in background
echo "Starting MySQL..."
mysqld --user=mysql --datadir=/var/lib/mysql --socket=/run/mysqld/mysqld.sock --port=3306 &

# Wait for MySQL to be ready (up to 60 seconds)
echo "Waiting for MySQL to be ready..."
for i in $(seq 1 60); do
    if mysqladmin ping --socket=/run/mysqld/mysqld.sock --silent 2>/dev/null; then
        echo "MySQL is ready."
        break
    fi
    if [ $i -eq 60 ]; then
        echo "MySQL failed to start within 60 seconds."
        exit 1
    fi
    sleep 1
done

# Create WordPress database and user (idempotent)
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

# Let the WordPress entrypoint handle wp-config.php setup AND start Apache
# docker-entrypoint.sh will generate wp-config.php if needed, then exec apache2-foreground
exec docker-entrypoint.sh apache2-foreground
