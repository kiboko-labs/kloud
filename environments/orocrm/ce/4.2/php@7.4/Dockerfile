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
    && EXPECTED_SIGNATURE="$(wget -q -O - https://composer.github.io/installer.sig)" \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && ACTUAL_SIGNATURE="$(php -r "echo hash_file('sha384', 'composer-setup.php');")" \
    && if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]; then >&2 echo 'ERROR: Invalid installer signature'; rm composer-setup.php; exit 1; fi \
    && php composer-setup.php --install-dir /usr/local/bin --filename composer --2 \
    && php -r "unlink('composer-setup.php');"
    && rm -rf /tmp/* /var/cache/apk/*
