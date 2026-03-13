FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libicu-dev libpng-dev \
    libxml2-dev libpq-dev libonig-dev \
    && docker-php-ext-install intl zip pdo pdo_pgsql mbstring xml gd bcmath ctype fileinfo \
    && apt-get clean

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

WORKDIR /app

COPY . .

RUN composer install --optimize-autoloader --no-dev --no-scripts --no-interaction --ignore-platform-reqs

RUN npm ci && npm run build

EXPOSE 8080

CMD php artisan config:cache && php artisan migrate --force && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=$PORT