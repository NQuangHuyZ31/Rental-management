FROM php:8.3-cli

# Cài dependency hệ thống
RUN apt-get update && apt-get install -y \
    git unzip curl \
    libpng-dev libjpeg-dev libfreetype6-dev

# Cài PHP extensions
RUN docker-php-ext-install pdo pdo_mysql gd

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# Cài dependencies PHP
RUN composer install

CMD ["sh", "-c", "php -S 0.0.0.0:$PORT index.php"]