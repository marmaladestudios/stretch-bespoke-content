#!/bin/bash
set -e

# Start MySQL temporarily to set up database
echo "Starting MySQL for initial setup..."
mysqld_safe &
sleep 5

# Wait for MySQL to be ready
for i in $(seq 1 30); do
    if mysqladmin ping -h localhost --silent 2>/dev/null; then
        break
    fi
    sleep 1
done

# Create WordPress database and user
mysql -u root <<-EOSQL
    CREATE DATABASE IF NOT EXISTS wordpress;
    CREATE USER IF NOT EXISTS 'wordpress'@'localhost' IDENTIFIED BY 'wordpress';
    GRANT ALL PRIVILEGES ON wordpress.* TO 'wordpress'@'localhost';
    FLUSH PRIVILEGES;
EOSQL

echo "MySQL database ready."

# Set WordPress DB config via environment
export WORDPRESS_DB_HOST="localhost"
export WORDPRESS_DB_USER="wordpress"
export WORDPRESS_DB_PASSWORD="wordpress"
export WORDPRESS_DB_NAME="wordpress"

# Run the original WordPress entrypoint to generate wp-config.php
docker-entrypoint.sh apache2 &
sleep 5

# Kill the temporary Apache — supervisor will manage both
pkill apache2 2>/dev/null || true
sleep 2

# Kill temporary MySQL — supervisor will manage it
mysqladmin -u root shutdown 2>/dev/null || true
sleep 2

# Start everything via supervisor
echo "Starting services via supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/supervisord.conf
