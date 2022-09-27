FROM php:8.1-cli-alpine

LABEL maintainer="Grégory Planchat <gregory@kiboko.fr>"

ARG APP_UID=1000
ARG APP_GID=1000
ARG APP_USERNAME=docker
ARG APP_GROUPNAME=docker

RUN set -ex\
    && addgroup -g ${APP_GID} ${APP_USERNAME} \
    && adduser -u ${APP_UID} -h /opt/${APP_USERNAME} -H -G ${APP_GROUPNAME} -s /sbin/nologin -D ${APP_USERNAME} \
    && apk update \
    && apk upgrade \
    && apk add \
        wget \
        ca-certificates \
        git \
        nodejs \
        npm \
        docker \
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
        libgomp \
        libltdl \
        libtool \
        mpc1 \
        musl-dev \
        perl \
        pkgconf \
        pkgconfig \
        python2 \
        re2c \
        readline \
        sqlite-libs \
    && rm -rf /tmp/* /var/cache/apk/* \
    && EXPECTED_SIGNATURE="$(wget -q -O - https://composer.github.io/installer.sig)" \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && ACTUAL_SIGNATURE="$(php -r "echo hash_file('sha384', 'composer-setup.php');")" \
    && if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]; then >&2 echo 'ERROR: Invalid installer signature'; rm composer-setup.php; exit 1; fi \
    && php composer-setup.php --install-dir /usr/local/bin --filename composer \
    && php -r "unlink('composer-setup.php');" \
    && curl -LSs https://box-project.github.io/box2/installer.php | php \
    && mv box.phar /usr/local/bin/box \
    && chmod +x /usr/local/bin/box \
    && mkdir -p /opt/docker/.npm \
    && chown docker:docker /opt/docker/.npm

ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

WORKDIR /app

COPY kloud.phar /opt/kloud/kloud.phar
COPY kloud.phar.pubkey /opt/kloud/kloud.phar.pubkey

RUN ln -s /opt/kloud/kloud.phar /usr/local/bin/kloud \
    && ln -s /opt/kloud/kloud.phar.pubkey /usr/local/bin/kloud.pubkey

ENTRYPOINT [ "/usr/local/bin/kloud" ]
