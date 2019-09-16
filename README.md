Docker images for Oro development stacks
===

* [Usage](#usage)
* [Tags](#tags)

Usage
---

### CLI images

```yaml
services:
  sh:
    image: kiboko/php:7.2-cli-blackfire-orocommerce-ee-3.1
    user: docker:docker
    volumes:
      - ./:/var/www/html
    restart: "no"

  sh-xdebug:
    image: kiboko/php:7.2-cli-xdebug-orocommerce-ee-3.1
    user: docker:docker
    volumes:
      - ./:/var/www/html
    restart: "no"

  blackfire:
    image: blackfire/blackfire
    environment:
        - BLACKFIRE_SERVER_ID
        - BLACKFIRE_SERVER_TOKEN
```

### FPM images

```yaml
services:
  fpm:
    image: kiboko/php:7.2-fpm-blackfire-orocommerce-ee-3.1
    user: docker:docker
    volumes:
      - ./:/var/www/html
    restart: "no"

  fpm-xdebug:
    image: kiboko/php:7.2-fpm-xdebug-orocommerce-ee-3.1
    user: docker:docker
    volumes:
      - ./:/var/www/html
    restart: "no"

  blackfire:
    image: blackfire/blackfire
    environment:
        - BLACKFIRE_SERVER_ID
        - BLACKFIRE_SERVER_TOKEN
```

### MacOS volumes optimisations

In order to optimize the IO performances in a Docker for mac stack, we recommend using those volumes configurations:

```yaml
volumes:

  # for CLI images only
  composer:
    driver: local
    driver_opts:
      type: tmpfs
      device: tmpfs
      o: "size=2048m,uid=1000,gid=1000"

  # for CLI and FPM images
  assets:
    driver: local
    driver_opts:
      type: tmpfs
      device: tmpfs
      o: "size=2048m,uid=1000,gid=1000"
  cache:
    driver: local
    driver_opts:
      type: tmpfs
      device: tmpfs
      o: "size=2048m,uid=1000,gid=1000"
```

In the service configuration, you will also need to mount those volumes with the `delegated` option, such as:

```yaml
services:
  sh:
    image: kiboko/php:7.2-cli-orocommerce-ee-3.1
    user: docker:docker
    volumes:
      - ./:/var/www/html
      - cache:/var/www/html/var/cache:delegated
      - assets:/var/www/html/public/bundles:delegated
    restart: "no"

  composer:
    extends:
      service: sh
    volumes:
      - composer:/opt/docker/.composer/:delegated
    environment:
      COMPOSER_AUTH: '{"github-oauth":{"github.com": "${COMPOSER_GITHUB_TOKEN}"}}'
    entrypoint: [ "composer" ]
    restart: "no"
```

Tags
---

* [OroPlatform Community Edition](#oroplatform-community-edition)
* [OroPlatform Enterprise Edition](#oroplatform-enterprise-edition)
* [OroCommerce Community Edition](#orocommerce-community-edition)
* [OroCommerce Enterprise Edition](#orocommerce-enterprise-edition)
* [OroCRM Enterprise Edition](#orocrm-enterprise-edition)

### OroPlatform Community Edition

#### Version 3.1

* PHP 7.1
  * CLI 
    * standard `7.1-cli-oroplatform-ce-3.1`
    * with Blackfire `7.1-cli-blackfire-oroplatform-ce-3.1`
    * with Xdebug `7.1-cli-xdebug-oroplatform-ce-3.1`
  * FPM
    * standard `7.1-fpm-oroplatform-ce-3.1`
    * with Blackfire `7.1-fpm-blackfire-oroplatform-ce-3.1`
    * with Xdebug `7.1-fpm-xdebug-oroplatform-ce-3.1`

* PHP 7.2
  * CLI 
    * standard `7.2-cli-oroplatform-ce-3.1`
    * with Blackfire `7.2-cli-blackfire-oroplatform-ce-3.1`
    * with Xdebug `7.2-cli-xdebug-oroplatform-ce-3.1`
  * FPM
    * standard `7.2-fpm-oroplatform-ce-3.1`
    * with Blackfire `7.2-fpm-blackfire-oroplatform-ce-3.1`
    * with Xdebug `7.2-fpm-xdebug-oroplatform-ce-3.1`

* PHP 7.3 (not supported)
  * CLI 
    * standard `7.3-cli-oroplatform-ce-3.1`
    * with Blackfire `7.3-cli-blackfire-oroplatform-ce-3.1`
    * with Xdebug `7.3-cli-xdebug-oroplatform-ce-3.1`
  * FPM 
    * standard `7.3-fpm-oroplatform-ce-3.1`
    * with Blackfire `7.3-fpm-blackfire-oroplatform-ce-3.1`
    * with Xdebug `7.3-fpm-xdebug-oroplatform-ce-3.1`

* PHP 7.4RC1 (not supported, experimental)
  * CLI
    * standard `7.4-cli-oroplatform-ce-3.1`
    * with Blackfire `7.4-cli-blackfire-oroplatform-ce-3.1`
    * with Xdebug `7.4-cli-xdebug-oroplatform-ce-3.1`
  * FPM
    * standard `7.4-fpm-oroplatform-ce-3.1`
    * with Blackfire `7.4-fpm-blackfire-oroplatform-ce-3.1`
    * with Xdebug `7.4-fpm-xdebug-oroplatform-ce-3.1`

#### Version 4.1

* PHP 7.1
  * CLI
    * standard `7.1-cli-oroplatform-ce-4.1`
    * with Blackfire `7.1-cli-blackfire-oroplatform-ce-4.1`
    * with Xdebug `7.1-cli-xdebug-oroplatform-ce-4.1`
  * FPM
    * standard `7.1-fpm-oroplatform-ce-4.1`
    * with Blackfire `7.1-fpm-blackfire-oroplatform-ce-4.1`
    * with Xdebug `7.1-fpm-xdebug-oroplatform-ce-4.1`

* PHP 7.2
  * CLI
    * standard `7.2-cli-oroplatform-ce-4.1`
    * with Blackfire `7.2-cli-blackfire-oroplatform-ce-4.1`
    * with Xdebug `7.2-cli-xdebug-oroplatform-ce-4.1`
  * FPM
    * standard `7.2-fpm-oroplatform-ce-4.1`
    * with Blackfire `7.2-fpm-blackfire-oroplatform-ce-4.1`
    * with Xdebug `7.2-fpm-xdebug-oroplatform-ce-4.1`

* PHP 7.3 (not supported)
  * CLI
    * standard `7.3-cli-oroplatform-ce-4.1`
    * with Blackfire `7.3-cli-blackfire-oroplatform-ce-4.1`
    * with Xdebug `7.3-cli-xdebug-oroplatform-ce-4.1`
  * FPM
    * standard `7.3-fpm-oroplatform-ce-4.1`
    * with Blackfire `7.3-fpm-blackfire-oroplatform-ce-4.1`
    * with Xdebug `7.3-fpm-xdebug-oroplatform-ce-4.1`

* PHP 7.4RC1 (not supported, experimental)
  * CLI
    * standard `7.4-cli-oroplatform-ce-4.1`
    * with Blackfire `7.4-cli-blackfire-oroplatform-ce-4.1`
    * with Xdebug `7.4-cli-xdebug-oroplatform-ce-4.1`
  * FPM
    * standard `7.4-fpm-oroplatform-ce-4.1`
    * with Blackfire `7.4-fpm-blackfire-oroplatform-ce-4.1`
    * with Xdebug `7.4-fpm-xdebug-oroplatform-ce-4.1`

### OroPlatform Enterprise Edition

#### Version 3.1

* PHP 7.1
  * CLI 
    * standard `7.1-cli-oroplatform-ee-3.1`
    * with Blackfire `7.1-cli-blackfire-oroplatform-ee-3.1`
    * with Xdebug `7.1-cli-xdebug-oroplatform-ee-3.1`
  * FPM
    * standard `7.1-fpm-oroplatform-ee-3.1`
    * with Blackfire `7.1-fpm-blackfire-oroplatform-ee-3.1`
    * with Xdebug `7.1-fpm-xdebug-oroplatform-ee-3.1`

* PHP 7.2
  * CLI 
    * standard `7.2-cli-oroplatform-ee-3.1`
    * with Blackfire `7.2-cli-blackfire-oroplatform-ee-3.1`
    * with Xdebug `7.2-cli-xdebug-oroplatform-ee-3.1`
  * FPM
    * standard `7.2-fpm-oroplatform-ee-3.1`
    * with Blackfire `7.2-fpm-blackfire-oroplatform-ee-3.1`
    * with Xdebug `7.2-fpm-xdebug-oroplatform-ee-3.1`

* PHP 7.3 (not supported)
  * CLI 
    * standard `7.3-cli-oroplatform-ee-3.1`
    * with Blackfire `7.3-cli-blackfire-oroplatform-ee-3.1`
    * with Xdebug `7.3-cli-xdebug-oroplatform-ee-3.1`
  * FPM 
    * standard `7.3-fpm-oroplatform-ee-3.1`
    * with Blackfire `7.3-fpm-blackfire-oroplatform-ee-3.1`
    * with Xdebug `7.3-fpm-xdebug-oroplatform-ee-3.1`

* PHP 7.4RC1 (not supported, experimental)
  * CLI
    * standard `7.4-cli-oroplatform-ee-3.1`
    * with Blackfire `7.4-cli-blackfire-oroplatform-ee-3.1`
    * with Xdebug `7.4-cli-xdebug-oroplatform-ee-3.1`
  * FPM
    * standard `7.4-fpm-oroplatform-ee-3.1`
    * with Blackfire `7.4-fpm-blackfire-oroplatform-ee-3.1`
    * with Xdebug `7.4-fpm-xdebug-oroplatform-ee-3.1`

#### Version 4.1

* PHP 7.1
  * CLI
    * standard `7.1-cli-oroplatform-ee-4.1`
    * with Blackfire `7.1-cli-blackfire-oroplatform-ee-4.1`
    * with Xdebug `7.1-cli-xdebug-oroplatform-ee-4.1`
  * FPM
    * standard `7.1-fpm-oroplatform-ee-4.1`
    * with Blackfire `7.1-fpm-blackfire-oroplatform-ee-4.1`
    * with Xdebug `7.1-fpm-xdebug-oroplatform-ee-4.1`

* PHP 7.2
  * CLI
    * standard `7.2-cli-oroplatform-ee-4.1`
    * with Blackfire `7.2-cli-blackfire-oroplatform-ee-4.1`
    * with Xdebug `7.2-cli-xdebug-oroplatform-ee-4.1`
  * FPM
    * standard `7.2-fpm-oroplatform-ee-4.1`
    * with Blackfire `7.2-fpm-blackfire-oroplatform-ee-4.1`
    * with Xdebug `7.2-fpm-xdebug-oroplatform-ee-4.1`

* PHP 7.3 (not supported)
  * CLI
    * standard `7.3-cli-oroplatform-ee-4.1`
    * with Blackfire `7.3-cli-blackfire-oroplatform-ee-4.1`
    * with Xdebug `7.3-cli-xdebug-oroplatform-ee-4.1`
  * FPM
    * standard `7.3-fpm-oroplatform-ee-4.1`
    * with Blackfire `7.3-fpm-blackfire-oroplatform-ee-4.1`
    * with Xdebug `7.3-fpm-xdebug-oroplatform-ee-4.1`

* PHP 7.4RC1 (not supported, experimental)
  * CLI
    * standard `7.4-cli-oroplatform-ee-4.1`
    * with Blackfire `7.4-cli-blackfire-oroplatform-ee-4.1`
    * with Xdebug `7.4-cli-xdebug-oroplatform-ee-4.1`
  * FPM
    * standard `7.4-fpm-oroplatform-ee-4.1`
    * with Blackfire `7.4-fpm-blackfire-oroplatform-ee-4.1`
    * with Xdebug `7.4-fpm-xdebug-oroplatform-ee-4.1`

### OroCommerce Enterprise Edition

#### Version 1.6

* PHP 7.1
  * CLI 
    * standard `7.1-cli-orocommerce-ee-1.6`
    * with Blackfire `7.1-cli-blackfire-orocommerce-ee-1.6`
    * with Xdebug `7.1-cli-xdebug-orocommerce-ee-1.6`
  * FPM
    * standard `7.1-fpm-orocommerce-ee-1.6`
    * with Blackfire `7.1-fpm-blackfire-orocommerce-ee-1.6`
    * with Xdebug `7.1-fpm-xdebug-orocommerce-ee-1.6`
    
#### Version 3.1

* PHP 7.1
  * CLI 
    * standard `7.1-cli-orocommerce-ee-3.1`
    * with Blackfire `7.1-cli-blackfire-orocommerce-ee-3.1`
    * with Xdebug `7.1-cli-xdebug-orocommerce-ee-3.1`
  * FPM
    * standard `7.1-fpm-orocommerce-ee-3.1`
    * with Blackfire `7.1-fpm-blackfire-orocommerce-ee-3.1`
    * with Xdebug `7.1-fpm-xdebug-orocommerce-ee-3.1`

* PHP 7.2
  * CLI 
    * standard `7.2-cli-orocommerce-ee-3.1`
    * with Blackfire `7.2-cli-blackfire-orocommerce-ee-3.1`
    * with Xdebug `7.2-cli-xdebug-orocommerce-ee-3.1`
  * FPM
    * standard `7.2-fpm-orocommerce-ee-3.1`
    * with Blackfire `7.2-fpm-blackfire-orocommerce-ee-3.1`
    * with Xdebug `7.2-fpm-xdebug-orocommerce-ee-3.1`
    
### OroCRM Enterprise Edition

#### Version 3.1

* PHP 7.1
  * CLI 
    * standard `7.1-cli-orocrm-ee-3.1`
    * with Blackfire `7.1-cli-blackfire-orocrm-ee-3.1`
    * with Xdebug `7.1-cli-xdebug-orocrm-ee-3.1`
  * FPM
    * standard `7.1-fpm-orocrm-ee-3.1`
    * with Blackfire `7.1-fpm-blackfire-orocrm-ee-3.1`
    * with Xdebug `7.1-fpm-xdebug-orocrm-ee-3.1`

* PHP 7.2
  * CLI 
    * standard `7.2-cli-orocrm-ee-3.1`
    * with Blackfire `7.2-cli-blackfire-orocrm-ee-3.1`
    * with Xdebug `7.2-cli-xdebug-orocrm-ee-3.1`
  * FPM
    * standard `7.2-fpm-orocrm-ee-3.1`
    * with Blackfire `7.2-fpm-blackfire-orocrm-ee-3.1`
    * with Xdebug `7.2-fpm-xdebug-orocrm-ee-3.1`