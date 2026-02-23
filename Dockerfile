# Base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip zip curl libonig-dev libxml2-dev default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql mbstring xml

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . /app

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Clear caches
RUN php artisan config:clear \
    && php artisan view:clear \
    && php artisan route:clear \
    && php artisan cache:clear

# Expose port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]