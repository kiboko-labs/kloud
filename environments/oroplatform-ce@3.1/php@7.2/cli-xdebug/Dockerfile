FROM php:7.2-cli-alpine

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
        git \
        nodejs \
        npm \
    && update-ca-certificates

RUN docker-php-ext-install opcache

RUN apk add --update zlib-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && apk del zlib-dev

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

RUN docker-php-source extract \
    && pecl install xdebug-2.6.1 \
    && docker-php-ext-enable xdebug \
    && docker-php-source delete

RUN apk add gnu-libiconv --update-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/community/ --allow-untrusted

ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

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

COPY config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY config/memory.ini /usr/local/etc/php/conf.d/memory.ini

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --install-dir /usr/local/bin --filename composer\
    && php -r "unlink('composer-setup.php');"

RUN mkdir -p /opt/docker/.npm \
    && chown docker:docker /opt/docker/.npm

WORKDIR /var/www/html
