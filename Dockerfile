FROM php:8.3-cli

# Cài extension cần thiết
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install gd

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]