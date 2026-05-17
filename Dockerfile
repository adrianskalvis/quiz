FROM node:20-alpine AS node_builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

FROM php:8.4-cli-alpine
RUN apk add --no-cache bash git curl unzip libzip-dev oniguruma-dev icu-dev sqlite-dev \
  && docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring intl zip
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY . .
COPY --from=node_builder /app/public/build /var/www/html/public/build
RUN composer install --no-dev --optimize-autoloader --no-interaction
EXPOSE 10000
CMD sh -c "php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"
