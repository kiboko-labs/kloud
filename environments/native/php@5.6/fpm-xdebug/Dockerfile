FROM kiboko/php:5.6-fpm

LABEL maintainer="Grégory Planchat <gregory@kiboko.fr>"

RUN set -ex\
    && apk add --virtual .build-deps \
        autoconf \
        bash \
        binutils \
        expat \
        file \
        g++ \
        gcc \
        m4 \
        make \
    && docker-php-source extract \
    && pecl install xdebug-2.5.5 \
    && docker-php-ext-enable xdebug \
    && docker-php-source delete \
    && apk del .build-deps \
    && rm -rf /tmp/* /var/cache/apk/*

COPY config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

