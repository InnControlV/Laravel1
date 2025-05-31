FROM php:8.2-apache

# Environment settings
ENV DEBIAN_FRONTEND=noninteractive \
    COMPOSER_MEMORY_LIMIT=-1

# Install required system packages
RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev libpng-dev libonig-dev libxml2-dev libssl-dev pkg-config gnupg && \
    docker-php-ext-install pdo pdo_mysql mbstring bcmath zip

# ✅ Install latest stable MongoDB extension (official)
RUN pecl install mongodb && docker-php-ext-enable mongodb
# Manually ensure it's loaded
RUN echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongodb.ini
# Enable Apache rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs || true

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 755 storage bootstrap/cache

EXPOSE 80
