# --- Stage 1: build frontend assets ---
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json* ./
RUN npm ci
COPY resources ./resources
COPY vite.config.js tailwind.config.js postcss.config.js ./
COPY public ./public
RUN npm run build

# --- Stage 2: PHP application ---
FROM php:8.3-fpm-alpine AS app

RUN apk add --no-cache \
        libpng-dev libjpeg-turbo-dev libwebp-dev freetype-dev libzip-dev icu-dev oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j"$(nproc)" pdo_mysql mbstring zip exif pcntl gd intl opcache

WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY . .
COPY --from=frontend /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist \
    && php artisan config:clear

RUN addgroup -g 1000 www && adduser -G www -u 1000 -D www \
    && chown -R www:www /var/www/html/storage /var/www/html/bootstrap/cache

USER www
EXPOSE 9000
CMD ["php-fpm"]
