# Stage 1
FROM php:8.2-cli-alpine AS build

RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    git \
    curl \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install mbstring gd zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . /app
COPY .env.example /app/.env

RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-suggest

RUN apk add --no-cache nodejs npm \
    && rm -rf node_modules package-lock.json \
    && npm install \
    && npm run build

RUN php artisan config:clear
RUN php artisan route:clear

RUN php artisan key:generate
RUN php artisan migrate

# Stage 2
FROM php:8.2-cli-alpine

RUN apk add --no-cache \
    libpng \
    libjpeg-turbo \
    freetype \
    libzip \
    ca-certificates \
    && update-ca-certificates

COPY --from=build /app /app
# RUN rm -f /app/.env

WORKDIR /app

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
