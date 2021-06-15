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
        zlib-dev \
        krb5-dev \
        imap-dev \
        openssl-dev \
    && apk add --update \
        c-client \
    && docker-php-source extract \
    && pecl install mongodb \
    && echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/ext-mongodb.ini \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap \
    && docker-php-source delete \
    && apk del .build-deps \
    && rm -rf /tmp/* /var/cache/apk/*
