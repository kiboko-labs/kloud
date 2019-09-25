FROM php:7.2-cli-alpine

LABEL maintainer="Grégory Planchat <gregory@kiboko.fr>"

ARG APP_UID=1000
ARG APP_GID=1000
ARG APP_USERNAME=docker
ARG APP_GROUPNAME=docker

RUN set -ex \
    && addgroup -g ${APP_GID} ${APP_USERNAME} \
    && adduser -u ${APP_UID} -h /opt/${APP_USERNAME} -H -G ${APP_GROUPNAME} -s /sbin/nologin -D ${APP_USERNAME} \
    && apk update \
    && apk upgrade \
    && apk add \
        wget \
        ca-certificates \
    && update-ca-certificates \
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
        libc-dev \
        libffi \
        libgcc \
        libgomp \
        libldap \
        libltdl \
        libmagic \
        libstdc++ \
        libtool \
        mpc1 \
        mpfr3 \
        musl-dev \
        perl \
        pkgconf \
        pkgconfig \
        python \
        re2c \
        readline \
        sqlite-libs \
    && rm -rf /tmp/* /var/cache/apk/*

ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

COPY config/pool.ini /usr/local/etc/php/pool.d/default.ini
COPY config/memory.ini /usr/local/etc/php/conf.d/memory.ini

WORKDIR /var/www/html
