FROM kiboko/php:8.0-fpm

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
    && ( \
        git clone git://github.com/xdebug/xdebug.git \
        && cd xdebug \
        && phpize \
        && autoconf \
        && ./configure \
        && make all -j5 \
        && make install \
        && cd - \
        && echo "extension=xdebug.so" > /usr/local/etc/php/conf.d/xdebug.ini \
        && rm -rf xdebug/ \
    ) \
    && docker-php-source delete \
    && apk del .build-deps \
    && rm -rf /tmp/* /var/cache/apk/*

COPY config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

