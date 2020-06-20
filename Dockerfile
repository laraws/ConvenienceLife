FROM php:7.4-fpm

RUN rm -f /etc/localtime
RUN ln -s /usr/share/zoneinfo/Asia/Shanghai /etc/localtime

# Copy composer.lock and composer.json
COPY ./docker-config/php/composer.phar /var/

# apt source
RUN cp /etc/apt/sources.list /etc/apt/sources.list.bak
COPY ./docker-config/apt/sources.list /etc/apt/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    default-mysql-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    cron \
    supervisor \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install  pdo_mysql \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install mysqli

# Install xdebug
RUN pecl install xdebug-2.8.1 \
    && docker-php-ext-enable xdebug

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
# RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
# RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
# RUN docker-php-ext-install gd

# Install composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN cd /var && mv composer.phar /usr/local/bin/composer
RUN composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/

COPY ./docker-config/php   /var/config
# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
