FROM php:8.2-apache

# Environment settings
ENV COMPOSER_MEMORY_LIMIT=-1 \
    DEBIAN_FRONTEND=noninteractive

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev libpng-dev libonig-dev libxml2-dev \
    libssl-dev pkg-config && \
    docker-php-ext-install pdo pdo_mysql mbstring bcmath zip

# Install MongoDB PHP extension
RUN rm -rf /tmp/pear ~/.pearrc && \
    pecl install mongodb && \
    echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongodb.ini
# Enable Apache rewrite module
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install Laravel dependencies
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs || (echo "Composer install failed" && cat /tmp/composer.log || true)

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
