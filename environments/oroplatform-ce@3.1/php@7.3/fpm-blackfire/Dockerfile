FROM php:7.3-fpm-alpine

LABEL maintainer="Grégory Planchat <gregory@kiboko.fr>"

ARG APP_UID=1000
ARG APP_GID=1000
ARG APP_USERNAME=docker
ARG APP_GROUPNAME=docker

RUN set -ex\
    && apk update \
    && apk upgrade \
    && echo "@testing http://nl.alpinelinux.org/alpine/edge/testing" >> /etc/apk/repositories \
    && apk add \
        shadow@testing \
        ca-certificates \
        libzip \
        wget \
        autoconf \
        bash \
        binutils \
        expat \
        file \
        g++ \
        gcc \
        m4 \
        make \
    && update-ca-certificates

RUN docker-php-ext-install opcache

RUN apk add --update libzip-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && apk del libzip-dev

RUN apk add --update libxml2-dev \
    && docker-php-ext-configure soap \
    && docker-php-ext-install soap \
    && apk del libxml2-dev

RUN apk add --update libpng-dev libjpeg-turbo-dev freetype-dev freetype libpng libjpeg-turbo \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd \
    && apk del libpng-dev libjpeg-turbo-dev freetype-dev

RUN apk add --update icu-dev icu \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && apk del icu-dev

RUN apk add --update postgresql-dev \
    && docker-php-ext-configure pdo_pgsql \
    && docker-php-ext-install pdo_pgsql \
    && apk del postgresql-libs

RUN docker-php-ext-configure bcmath \
    && docker-php-ext-install bcmath

RUN apk add tidyhtml \
    && apk add --update tidyhtml-dev \
    && docker-php-ext-configure tidy \
    && docker-php-ext-install tidy \
    && apk del tidyhtml-dev

RUN apk add c-client \
    && apk add --update krb5-dev imap-dev \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap \
    && apk del krb5-dev imap-dev

RUN apk add openldap \
    && apk add --update openldap-dev \
    && docker-php-ext-configure ldap --with-ldap \
    && docker-php-ext-install ldap \
    && apk del openldap-dev

RUN apk add gnu-libiconv --update-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/community/ --allow-untrusted

ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

# From: https://blackfire.io/docs/integrations/docker
ENV current_os=alpine
RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/$current_os/amd64/$version \
    && mkdir -p /tmp/blackfire \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp/blackfire \
    && mv /tmp/blackfire/blackfire-*.so $(php -r "echo ini_get('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini \
    && rm -rf /tmp/blackfire /tmp/blackfire-probe.tar.gz

RUN apk del \
        autoconf \
        bash \
        binutils \
        expat \
        file \
        g++ \
        gcc \
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
        m4 \
        make \
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

RUN addgroup -g ${APP_GID} ${APP_USERNAME} \
    && adduser -u ${APP_UID} -h /opt/${APP_USERNAME} -H -G ${APP_GROUPNAME} -s /sbin/nologin -D ${APP_USERNAME}

COPY config/pool.ini /usr/local/etc/php/pool.d/default.ini
COPY config/memory.ini /usr/local/etc/php/conf.d/memory.ini

WORKDIR /var/www/html
