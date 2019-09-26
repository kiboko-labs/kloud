ARG FLAVOR
ARG ORO_VERSION

FROM kiboko/php:7.2-${FLAVOR}-oroplatform-ce-${ORO_VERSION}-mysql

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
        libxml2-dev \
        tidyhtml-dev \
        openldap-dev \
    && apk add \
        tidyhtml \
        openldap \
        libmcrypt \
    && docker-php-ext-configure soap \
    && docker-php-ext-install soap \
    && docker-php-ext-configure bcmath \
    && docker-php-ext-install bcmath \
    && docker-php-ext-configure tidy \
    && docker-php-ext-install tidy \
    && docker-php-ext-configure ldap --with-ldap \
    && docker-php-ext-install ldap \
    && rm -rf /tmp/* /var/cache/apk/*
