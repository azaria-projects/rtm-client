# Stage 1: Build with Composer, Node, etc.
FROM php:8.2-cli AS build

# Install dependencies (Debian-based)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mbstring zip \
    && apt-get clean

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer

WORKDIR /app
COPY . /app
COPY .env.example /app/.env

# Install PHP deps
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-suggest

# Install and build frontend assets
RUN rm -rf node_modules package-lock.json \
    && npm install \
    && npm run build

# Laravel prep
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan key:generate \
    && php artisan migrate

---

# Stage 2: Clean runtime container
FROM php:8.2-cli

# Install only required runtime libs
RUN apt-get update && apt-get install -y \
    libpng16-16 \
    libjpeg62-turbo \
    libfreetype6 \
    libzip4 \
    ca-certificates \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy built app
COPY --from=build /app /app
WORKDIR /app

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
