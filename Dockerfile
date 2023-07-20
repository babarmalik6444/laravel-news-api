FROM php:8.2.0alpha1-fpm-alpine

# Install necessary packages and extensions
RUN apk update && \
    apk add --no-cache \
        curl \
        git \
        libpng-dev \
        libzip-dev \
        zip \
        unzip && \
    docker-php-ext-install pdo_mysql gd zip

# Start the PHP-FPM server
CMD ["php-fpm"]
