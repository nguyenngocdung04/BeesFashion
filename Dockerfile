# Sử dụng image chính thức của PHP 8.2 với máy chủ web Apache
FROM php:8.2-apache

# Cài đặt các thư viện hệ thống cần thiết cho Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libvips-dev \
    zip \
    unzip \
    git \
    curl \
    vim \
    && rm -rf /var/lib/apt/lists/*

# Cài đặt các extension PHP phổ biến cho Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_mysql zip exif pcntl gd

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Đặt thư mục làm việc là /var/www/html
WORKDIR /var/www/html

# Sao chép mã nguồn ứng dụng của bạn vào container
COPY . .

# --- THAY ĐỔI QUAN TRỌNG BẮT ĐẦU TỪ ĐÂY ---

# 1. Tạo file .env từ .env.example để các lệnh artisan có thể chạy
RUN cp .env.example .env

# 2. Cài đặt các gói PHP
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 3. Tạo APP_KEY và cache config để tối ưu hóa
RUN php artisan key:generate
RUN php artisan config:cache

# --- KẾT THÚC THAY ĐỔI QUAN TRỌNG ---

# Xây dựng các tài nguyên frontend (JS/CSS)
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs
RUN npm install && npm run build

# Sao chép file cấu hình Apache để trỏ vào thư mục /public của Laravel
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Tạo một file .ini tùy chỉnh để ẩn các cảnh báo không cần thiết
RUN echo "error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_WARNING & ~E_NOTICE" > /usr/local/etc/php/conf.d/zz-custom-error-reporting.ini

# Thay đổi quyền sở hữu cho thư mục storage và bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Lệnh này sẽ chạy khi container khởi động
CMD ["apache2-foreground"]