FROM php:7.4.12-fpm

ARG user
ARG uid

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libmagickwand-dev \
    libyaml-dev

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql zip exif pcntl bcmath gd

RUN pecl install -o -f yaml \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable yaml

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/ && \
    chown -R $user:$user /home/$user

WORKDIR /var/www

USER $user

EXPOSE 9000
CMD ["php-fpm"]
