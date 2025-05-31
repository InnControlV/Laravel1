FROM phpswoole/swoole:php8.2

# Apache and other system deps
RUN apt update && apt install -y apache2 libapache2-mod-php8.2 && \
    apt install -y unzip zip libzip-dev libpng-dev libonig-dev libxml2-dev git curl

# Enable PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring bcmath zip

# ✅ MONGODB EXTENSION ALREADY INSTALLED in this image

# Enable apache rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Working directory
WORKDIR /var/www/html

COPY . .

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs || (echo "Composer install failed" && cat /tmp/composer.log || true)

RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 755 storage bootstrap/cache

EXPOSE 80
CMD ["apache2ctl", "-D", "FOREGROUND"]
