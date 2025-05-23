FROM php:8.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev libpng-dev libonig-dev libxml2-dev libssl-dev pkg-config \
    && docker-php-ext-install pdo pdo_mysql mbstring bcmath zip

# Install MongoDB PHP extension with SSL support
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Enable Apache rewrite module
RUN a2enmod rewrite

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy project files
COPY . .
ENV COMPOSER_MEMORY_LIMIT=-1

# Install PHP dependencies
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader

# Set permissions for Laravel storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
