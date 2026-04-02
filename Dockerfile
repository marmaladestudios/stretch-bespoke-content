FROM wordpress:latest

# Install MySQL server
RUN apt-get update && apt-get install -y \
    default-mysql-server \
    && rm -rf /var/lib/apt/lists/*

# Install WP-CLI
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp

# Increase PHP limits
RUN echo 'upload_max_filesize = 64M' > /usr/local/etc/php/conf.d/uploads.ini \
    && echo 'post_max_size = 64M' >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo 'memory_limit = 256M' >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo 'max_execution_time = 120' >> /usr/local/etc/php/conf.d/uploads.ini

# Copy theme to a staging location (WordPress entrypoint overwrites /var/www/html at runtime)
COPY stretch-theme/ /opt/stretch-theme/
COPY setup-content.php /opt/setup-content.php
COPY setup-images.php /opt/setup-images.php
COPY setup-logos.php /opt/setup-logos.php
COPY setup-team-photos.php /opt/setup-team-photos.php
COPY setup-services.php /opt/setup-services.php

# Ensure MySQL directories exist
RUN mkdir -p /var/run/mysqld && chown mysql:mysql /var/run/mysqld

# Init script
COPY docker-entrypoint-custom.sh /usr/local/bin/docker-entrypoint-custom.sh
RUN chmod +x /usr/local/bin/docker-entrypoint-custom.sh

EXPOSE 80

CMD ["/usr/local/bin/docker-entrypoint-custom.sh"]
