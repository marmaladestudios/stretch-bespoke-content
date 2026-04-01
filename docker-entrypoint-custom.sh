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

# Run WordPress docker-entrypoint to set up wp-config.php (if not exists)
if [ ! -f /var/www/html/wp-config.php ]; then
    echo "Running WordPress setup..."
    # Source the WordPress entrypoint function
    docker-entrypoint.sh apache2-foreground &
    sleep 8
    # Kill Apache — we'll restart it properly
    pkill -f apache2 2>/dev/null || true
    sleep 2
fi

echo "Starting Apache..."
exec apache2-foreground
