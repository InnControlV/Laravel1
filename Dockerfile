FROM php:8.2-apache

# Set environment variables
ENV COMPOSER_MEMORY_LIMIT=-1 \
    DEBIAN_FRONTEND=noninteractive

# Install system dependencies and tools needed for PECL and mongodb extension
RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev libpng-dev libonig-dev libxml2-dev \
    libssl-dev pkg-config autoconf g++ make

# Install PHP extensions including mongodb
RUN pecl install mongodb && docker-php-ext-enable mongodb && php -m
RUN service apache2 restart
# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy Composer binary
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install Laravel dependencies
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs || (echo "Composer install failed" && cat /tmp/composer.log || true)

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80

# Show enabled PHP extensions for debugging
RUN php -m
