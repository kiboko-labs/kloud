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
        librdkafka-dev \
        git \
    && apk add --update \
        c-client \
        librdkafka \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap \
    && ( \
        git clone https://github.com/arnaud-lb/php-rdkafka.git \
        && cd php-rdkafka \
        && phpize \
        && autoconf \
        && ./configure \
        && make all -j5 \
        && make install \
        && cd - \
        && echo "extension=rdkafka.so" > /usr/local/etc/php/conf.d/rdkafka.ini \
    ) \
    && apk del .build-deps \
    && rm -rf /tmp/* /var/cache/apk/*
