FROM php:8.3-fpm

# set working directory
WORKDIR /var/www/tbc

#ARG CACHEBUST=1

ENV XDEBUG_MODE="debug,coverage"
# Install system dependencies
RUN apt-get update -y && apt-get upgrade -y && apt-get install -y \
    curl \
    vim \
    git \
    libpng-dev \
    libonig-dev \
    libpq-dev \
    libxml2-dev \
    libzip-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libfreetype6-dev \
    unzip \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
        bcmath \
        exif \
        gd \
        mbstring \
        mysqli \
        pdo \
        pdo_mysql \
        zip \
    && docker-php-ext-enable \
        bcmath \
        exif \
        gd \
        mbstring \
        mysqli \
        pdo \
        pdo_mysql

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions xdebug

COPY docker/xdebug/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/

#install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#COPY docker/cron/root /etc/cron.d/root
#RUN chmod 0644 /etc/cron.d/root


#EXPOSE 9000
CMD ["php-fpm"]
