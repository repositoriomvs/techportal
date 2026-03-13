FROM php:8.3-cli

# Instalar extensiones
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libicu-dev libpng-dev \
    libxml2-dev libpq-dev libonig-dev nodejs npm \
    && docker-php-ext-install intl zip pdo pdo_pgsql mbstring xml gd bcmath ctype fileinfo \
    && apt-get clean

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

WORKDIR /app

COPY . .

RUN composer install --optimize-autoloader --no-dev --no-scripts --no-interaction

RUN npm ci && npm run build

RUN php artisan config:cache || true

EXPOSE 8080

CMD php artisan migrate --force && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=$PORT
