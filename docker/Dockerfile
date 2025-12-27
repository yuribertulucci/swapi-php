FROM shinsenter/phpfpm-nginx:php7.4-alpine

# Install PHP extensions
RUN phpaddmod pdo pdo_mysql mysqli mbstring exif pcntl bcmath gd

# Set working directory
WORKDIR /var/www/html

# Install composer dependencies
COPY composer.json composer.lock /var/www/html/
RUN composer install --optimize-autoloader --working-dir=/var/www/html
