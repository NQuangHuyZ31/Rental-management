FROM php:8.3-cli

# Cài extension cần thiết
RUN docker-php-ext-install pdo pdo_mysql

# Cài GD (nếu cần xử lý ảnh)
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install gd

WORKDIR /app

COPY . .

# Start server với router.php + PORT từ Railway
CMD ["sh", "-c", "php -S 0.0.0.0:$PORT index.php"]