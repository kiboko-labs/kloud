FROM php:8.0-rc-fpm-alpine

LABEL maintainer="Grégory Planchat <gregory@kiboko.fr>"

ARG APP_UID=1000
ARG APP_GID=1000
ARG APP_USERNAME=docker
ARG APP_GROUPNAME=docker

ENV PHP_EXTRA_CONFIGURE_ARGS="--enable-fpm --with-fpm-user=${APP_USERNAME} --with-fpm-group=${APP_GROUPNAME} --disable-cgi"
ENV HOME=/opt/${APP_USERNAME}

RUN set -ex \
    && addgroup -g ${APP_GID} ${APP_USERNAME} \
    && adduser -u ${APP_UID} -h /opt/${APP_USERNAME} -H -G ${APP_GROUPNAME} -s /sbin/nologin -D ${APP_USERNAME} \
    && apk update \
    && apk upgrade \
    && apk add \
        wget \
        ca-certificates \
    && update-ca-certificates \
    && apk add --virtual .build-deps $PHPIZE_DEPS \
    && docker-php-ext-install opcache \
    && apk add --update icu-dev icu \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && apk del icu-dev \
    && apk add gnu-libiconv --update-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/community/ --allow-untrusted \
    && apk del \
        .build-deps \
        gdbm \
        gmp \
        isl \
        libatomic \
        libbz2 \
        libffi \
        libgcc \
        libgomp \
        libldap \
        libltdl \
        libmagic \
        libtool \
        mpc1 \
        musl-dev \
        perl \
        pkgconf \
        pkgconfig \
        python3 \
        re2c \
        readline \
        sqlite-libs \
    && rm -rf /tmp/* /var/cache/apk/* \
    && mkdir -p /opt/${APP_USERNAME}/.composer \
    && chown -R ${APP_USERNAME}:${APP_GROUPNAME} /opt/${APP_USERNAME}

ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

COPY config/pool.ini /usr/local/etc/php/pool.d/default.ini
COPY config/memory.ini /usr/local/etc/php/conf.d/memory.ini
COPY config/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www/html
