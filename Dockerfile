FROM php:8.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring bcmath zip

# Install MongoDB PHP extension
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Enable Apache rewrite module
RUN a2enmod rewrite

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# Install PHP dependencies without running scripts (optional)
RUN composer install --no-dev --optimize-autoloader --no-scripts || (echo "Composer install failed:" && cat /tmp/composer.log || true)

# Set permissions for Laravel storage and cache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

EXPOSE 80
