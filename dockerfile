FROM dunglas/frankenphp:php8.2.30-bookworm

# تثبيت الامتدادات المطلوبة
RUN install-php-extensions \
    gd ctype curl dom fileinfo filter hash mbstring openssl pcre pdo session tokenizer xml \
    zip sodium opcache

# نسخ ملفات المشروع
COPY . /app
WORKDIR /app

# تثبيت Composer dependencies
RUN composer install --optimize-autoloader --no-scripts --no-interaction

# تثبيت Node dependencies وبناء الأصول
RUN npm install && npm run build

# تشغيل أوامر Laravel
RUN php artisan config:cache \
    && php artisan event:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache \
    && chmod -R a+rw storage bootstrap/cache

CMD ["vendor/bin/heroku-php-apache2", "public/"]