# Stage 1
FROM php:8.2-cli AS build

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mbstring zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer

WORKDIR /app
COPY . /app
COPY .env.example /app/.env

RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-suggest

RUN rm -rf node_modules package-lock.json \
    && npm install \
    && npm run build

RUN php artisan key:generate \
    php artisan config:clear \
    && php artisan route:clear \
    && php artisan key:generate \
    && php artisan migrate

# Stage 2:
FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libpng16-16 \
    libjpeg62-turbo \
    libfreetype6 \
    ca-certificates \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=build /app /app
WORKDIR /app

EXPOSE 8101

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8101"]
