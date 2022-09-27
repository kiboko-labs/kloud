ARG SOURCE_VARIATION

FROM kiboko/php:${SOURCE_VARIATION}

LABEL maintainer="Grégory Planchat <gregory@kiboko.fr>"

RUN set -ex \
    && apk add --virtual .build-deps \
        $PHPIZE_DEPS \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        libzip-dev \
        krb5-dev \
        imap-dev \
        openssl-dev \
    && apk add --update \
        freetype \
        libpng \
        libjpeg-turbo \
        libzip \
        c-client \
        openssl \
    && docker-php-source extract \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-configure sockets \
    && docker-php-ext-install sockets \
    && PHP_OPENSSL=yes docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap \
    && docker-php-source delete \
    && apk del .build-deps \
    && rm -rf /tmp/* /var/cache/apk/*
