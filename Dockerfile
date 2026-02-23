# Base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /app

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip zip curl libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring xml

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . /app

# Install PHP dependencies (without dev packages for production)
RUN composer install --no-dev --optimize-autoloader \
    || composer install --ignore-platform-reqs --no-dev --optimize-autoloader

# Create SQLite DB and run migrations
RUN mkdir -p /app/database && touch /app/database/database.sqlite \
    && php artisan migrate --force \
    && php artisan config:clear \
    && php artisan cache:clear \
    && php artisan view:clear

# Expose port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]