FROM php:8.0-fpm-bullseye AS php-base

RUN apt-get update && \
    apt-get install -y unzip

COPY --from=mlocati/php-extension-installer:1.2.60 /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions \
    opcache \
    pdo_mysql \
    intl \
    zip \
    uuid-1.2.0 \
    xdebug-3.1.1 \
    gd \
    yaml

# install composer
COPY --from=composer:2.1.9 /usr/bin/composer /usr/bin

# apply config
RUN rm -rf /usr/local/etc/php/conf.d/* \
 && rm -rf /usr/local/etc/php-fpm.d/*
COPY docker/php/config/ /usr/local/etc/
COPY docker/php/html /var/www/html/

WORKDIR /app

ENV PHP_FPM_WORKERS=${PHP_FPM_WORKERS:-5}
ENV PHP_SOCKET_TIMEOUT=${PHP_SOCKET_TIMEOUT:-60}

FROM php-base AS php-dev

# install fixuid
RUN curl -SsL https://github.com/boxboat/fixuid/releases/download/v0.5/fixuid-0.5-linux-amd64.tar.gz | tar -C /usr/local/bin -xzf - && \
    chown root:root /usr/local/bin/fixuid && \
    chmod 4755 /usr/local/bin/fixuid && \
    mkdir -p /etc/fixuid && \
    printf "user: www-data\ngroup: www-data\n" > /etc/fixuid/config.yml

ARG BUILD_VERSION
ENV APP_VERSION=$BUILD_VERSION

USER www-data
ENTRYPOINT ["fixuid", "-q"]
CMD ["php-fpm", "-dzend_extension=xdebug"]

FROM php-base AS php-builder

# warmup vendor dir
COPY composer.json composer.lock ./
RUN composer install -a --no-dev --no-progress --no-scripts

# add project files
COPY . .

# compile project
RUN composer prod

# remove stuff
RUN composer clear-cache

FROM php-base AS php-prod

COPY --from=php-builder /app /app
COPY --from=php-builder --chown=www-data:www-data /app/var /app/var

ARG BUILD_VERSION
ENV APP_VERSION=$BUILD_VERSION

USER www-data
CMD ["php-fpm", "-dopcache.validate_timestamps=0", "-dopcache.preload=/app/config/preload.php"]
