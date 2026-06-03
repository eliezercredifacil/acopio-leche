FROM dunglas/frankenphp:php8.4

WORKDIR /app

RUN install-php-extensions \
    pdo_mysql \
    bcmath \
    intl \
    zip \
    opcache \
    pcntl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

EXPOSE 8080

CMD ["php", "artisan", "octane:frankenphp", "--host=0.0.0.0", "--port=8000"]