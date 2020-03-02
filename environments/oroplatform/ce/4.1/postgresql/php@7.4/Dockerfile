ARG SOURCE_VARIATION

FROM kiboko/php:${SOURCE_VARIATION}

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
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        libzip-dev \
        krb5-dev \
        imap-dev \
        openssl-dev \
        postgresql-dev \
    && apk add --update \
        freetype \
        libpng \
        libjpeg-turbo \
        c-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-configure imap --with-kerberos \
    && docker-php-ext-install imap \
    && docker-php-ext-configure pdo_pgsql \
    && docker-php-ext-install pdo_pgsql \
    && apk del .build-deps \
    && rm -rf /tmp/* /var/cache/apk/*
