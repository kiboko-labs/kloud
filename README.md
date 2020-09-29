Docker images and stacks for Oro and Marello development
===

This project aims at building your Docker stack for [OroCommerce](https://oroinc.com/b2b-ecommerce/), [OroCRM](https://oroinc.com/orocrm/), [OroPlatform](https://oroinc.com/oroplatform/) and [Marello](https://www.marello.com/) development.

> ⚠️ Nota: Those stacks are not suited for production hosting, but to provide an environment based on Docker as identical as possible to OroCloud on a personal computer.

* [Installation](#installation)
* [Usage](#usage)
* [Frequently Asked Questions](#frequently-asked-questions)
* [Supported versions and flavors](#supported-versions-and-flavours)
  * [OroPlatform](#oroplatform)
  * [OroCRM](#orocrm)
  * [OroCommerce](#orocommerce)
  * [Marello](#marello)
  * [Middleware](#middleware)

Installation
---

### Installing system-wide the `kloud` command

While installing system-wide, you will need administrator privilleges to install the command inside `/usr/local/bin/` directory.

```
sudo curl -L -o /usr/local/bin/kloud https://github.com/kiboko-labs/docker-images/releases/latest/download/kloud.phar
sudo curl -L -o /usr/local/bin/kloud.pubkey https://github.com/kiboko-labs/docker-images/releases/latest/download/kloud.phar.pubkey
sudo chmod +x /usr/local/bin/kloud
```

### Installing the Phar package in your project

While installing in your project, no administrator privilege is required, the phar package will be available in the `bin/` directory.

```
curl -L -o bin/kloud.phar https://github.com/kiboko-labs/docker-images/releases/latest/download/kloud.phar
curl -L -o bin/kloud.phar.pubkey https://github.com/kiboko-labs/docker-images/releases/latest/download/kloud.phar.pubkey
chmod +x bin/kloud.phar
```

We also recommend to add both files to your `.gitignore` file.

### If you want to use the pre-packaged docker image

If you do not want to install the command on your machine, a Docker image is ready for one-shot usages and can be executed this way:

```
docker run --rm -ti -v /var/run/docker.sock:/var/run/docker.sock \
    -v $HOME/.docker:/opt/docker/.docker \
    -v $PWD:/app \
    kiboko/kloud <command>
```

Usage
---

### Initialize your stack

In a new project, after cloning the original application repository, you can initialize the Docker stack configuration you will need.
You can invoke the following command that will guess what you need and a wizard will ask you a few questions about your preferences:

`kloud stack:init`

Once the command is finished, you will have a file named `.env.dist` containing the required environment variables for the stack.
This file has to be renamed to `.env` in order to be used by Docker Compose.
The command have set some ports values for all services, you may wish to change them depending on your environment.

#### Available command line options

* Database engine selection
  * `--mysql`: Set up the application to use MySQL.
  * `--postgresql`: Set up the application to use PostgreSQL.

* Xdebug a debugger for PHP
  * `--with-xdebug`: Set up the application to use Xdebug.
  * `--without-xdebug`: Set up the application without Xdebug.

* Blackfire an APM for PHP performance optimizations
  * `--with-blackfire`: Set up the application to use Blackfire.
  * `--without-blackfire`: Set up the application without Blackfire.

* Dejavu, An ElasticSearch UI
  * `--with-dejavu`: Set up the application to use Dejavu UI.
  * `--without-dejavu`: Set up the application without Dejavu UI.

* Elastic Stack for application logging
  * `--with-elastic-stack`: Set up the application to use Elastic Stack logging.
  * `--without-elastic-stack`: Set up the application without Elastic Stack logging.

* Mac OS optimizations on data volumes
  * `--with-macos-optimizations`: Set up the application to use Docker for Mac optimizations.
  * `--without-macos-optimizations`: Set up the application without Docker for Mac optimizations.

### Update your stack

In an existing project, you can upgrade the docker stack configuration. automagically.
You can invoke the following command that will guess what services needs to be updated and in case of differences, a wizard will ask you what you wish to keep or delete:

`kloud stack:update`

### Build the required images

If you need to build the images you need in a stack, you can execute the following command:

`kloud image:build`

To enable experimental images, you will need to add option `--with-experimental`.
  
### Test the required images

If you need to test if the images you are using are following every constraint you would expect:

`kloud image:test`

Frequently Asked Questions
---

### I am having some warnings while launching `docker-compose up` for the first time

If you are having this sort of messages:

```
WARNING: The MAILCATCHER_PORT variable is not set. Defaulting to a blank string.
ERROR: The Compose file './docker-compose.yml' is invalid because:
services.mail.ports contains an invalid type, it should be a number, or an object
```

Those warnings and errors are due to missing environment variables, probably because you did 
not copy the `.env.dist` file to a `.env` file.

### What is the use of the `I_AM_DEVELOPER_DISABLE_INDEX_IP_CHECK` environment variable?

This environment variable is used to disable the IP check in the `public/index_dev.php` file.
To benefit from this feature, you will need to apply the following patch: 

```patch
Index: public/index_dev.php
IDEA additional info:
Subsystem: com.intellij.openapi.diff.impl.patch.CharsetEP
<+>UTF-8
===================================================================
--- public/index_dev.php
+++ public/index_dev.php
@@ -13,9 +13,12 @@
 
 // This check prevents access to debug front controllers that are deployed by accident to production servers.
 // Feel free to remove this, extend it, or make something more sophisticated.
-if (isset($_SERVER['HTTP_CLIENT_IP'])
-    || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
-    || !in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1'))
+if (!isset($_ENV['I_AM_DEVELOPER_DISABLE_INDEX_IP_CHECK'])
+    && (
+        isset($_SERVER['HTTP_CLIENT_IP'])
+        || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
+        || !in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1'))
+    )
 ) {
     header('HTTP/1.0 403 Forbidden');
     exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
```

### How to access My application's frontend?

The application frontend can be accessed through the port defined in the `HTTP_PORT`
environment variable value.

### How to configure the mailer in the `parameters.yml` file?

The parameters should be set as the following:

```yaml
parameters:
    mailer_transport: smtp
    mailer_host: mail
    mailer_port: 1025
    mailer_encryption: null
    mailer_user: null
    mailer_password: null
```

Notice that the `MAILER_PORT` variable is not used, as this port is the one from your 
computer's point of view, not a container's point of view in the stack.

### How to configure the websocket service in the `parameters.yml` file?

The parameters should be set as the following on Oro 4.1+:

```yaml
parameters:
    websocket_bind_address: 0.0.0.0
    websocket_bind_port: 8080
    websocket_frontend_host: '*'
    websocket_frontend_port: '%env(WEBSOCKET_PORT)%'
    websocket_frontend_path: ''
    websocket_backend_host: '*'
    websocket_backend_port: '%env(WEBSOCKET_PORT)%'
    websocket_backend_path: ''
    websocket_backend_transport: tcp
    websocket_backend_ssl_context_options: {  }
```

Notice that the `WEBSOCKET_PORT` variable is not used for the `websocket_bind_port`, as this
port is the one from your computer's point of view, not a container's point of view in the stack.

### How to configure the database service in the `parameters.yml` file?

The parameters should be set as the following on Oro 4.1+:

```yaml
parameters:
    database_driver: pdo_pgsql
    database_host: sql
    database_port: null
    database_name: '%env(DATABASE_NAME)%'
    database_user: '%env(DATABASE_USER)%'
    database_password: '%env(DATABASE_PASS)%'
    database_driver_options: {  }
```

Notice that the `DATABASE_PORT` variable is not used, as this port is the one from your 
computer's point of view, not a container's point of view in the stack.

### How to configure the search engine service in the `parameters.yml` file?

The parameters should be set as the following:

```yaml
parameters:
    search_engine_name: elastic_search
    search_engine_host: elasticsearch
    search_engine_port: null
    search_engine_index_prefix: oro_search
    search_engine_username: null
    search_engine_password: null
    search_engine_ssl_verification: null
    search_engine_ssl_cert: null
    search_engine_ssl_cert_password: null
    search_engine_ssl_key: null
    search_engine_ssl_key_password: null
    website_search_engine_index_prefix: oro_website_search
```

Notice that the `ELASTICSEARCH_PORT` variable is not used, as this port is the one from your 
computer's point of view, not a container's point of view in the stack.

### How to configure the message queue service in the `parameters.yml` file?

The parameters should be set as the following:

```yaml
parameters:
    message_queue_transport: amqp
    message_queue_transport_config:
        host: amqp
        port: '5672'
        user: '%env(RABBITMQ_USER)%'
        password: '%env(RABBITMQ_PASSWORD)%'
        vhost: /
```

Notice that the `ELASTICSEARCH_PORT` variable is not used, as this port is the one from your 
computer's point of view, not a container's point of view in the stack.

### How to access to Mailcatcher's interface?

The Mailcatcher interface can be accessed through the port defined in the `MAILCATCHER_PORT`
environment variable value.

### How to access RabbitMQ manager's interface?

The RabbitMQ manager interface can be accessed through the port defined in the `RABBITMQ_PORT`
environment variable value.

### How to access Dejavu's interface for Elasticsearch?

The Dejavu interface can be accessed through the port defined in the `DEJAVU_PORT`
environment variable value.

Additionnally, the `ELASTICSEARCH_PORT` variable should be defined in order to make
Elasticsearch's API accessible from your computer.

### How to access Elasticsearch's API?

The Elasticsearch API can be accessed through the port defined in the `ELASTICSEARCH_PORT`
environment variable value.

### How to access Kibana's interface?

The Kibana interface can be accessed through the port defined in the `KIBANA_PORT`
environment variable value.

### How to access Redis service from your computer?

The Redis servcie can be accessed through the port defined in the `REDIS_PORT`
environment variable value.

### How to access MySQL or PostgreSQL service from your computer?

The MySQL or PostgreSQL servcie can be accessed through the port defined in the `DATABASE_PORT`
environment variable value.

Supported versions and flavours
---

### OroPlatform

#### Community Edition

* ✅ available
* ❌ no support
* 🌅️ discontinued
* ⚠️ experimental

| Version | PHP 5.6 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 |
| ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| ^1.8    | 🌅️      | ❌      | ❌      | ❌      | ❌️      | ❌      |
| ^1.10   | 🌅️      | ❌      | ❌      | ❌      | ❌️      | ❌      |
| ^2.6    | 🌅️      | 🌅️      | ❌      | ❌      | ❌️      | ❌      |
| ^3.1    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^4.1    | ❌      | ❌      | ❌      | ✅️      | ✅️      | ⚠️      |

#### Enterprise Edition

* ✅ available
* ❌ no support
* 🌅️ discontinued
* ⚠️ experimental

| Version | PHP 5.6 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 |
| ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| ^1.12   | 🌅️      | ❌      | ❌      | ❌      | ❌️      | ❌      |
| ^2.6    | 🌅️      | 🌅️      | ❌      | ❌      | ❌️      | ❌      |
| ^3.1    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^4.1    | ❌      | ❌      | ❌      | ✅️      | ✅️      | ⚠️      |

### OroCRM

#### Community Edition

* ✅ available
* ❌ no support
* 🌅️ discontinued
* ⚠️ experimental

| Version | PHP 5.6 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 |
| ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| ^2.6    | 🌅️      | 🌅️      | ❌      | ❌      | ❌️      | ❌      |
| ^3.1    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^4.1    | ❌      | ❌      | ❌      | ✅️      | ✅️      | ⚠️      |

#### Enterprise Edition

* ✅ available
* ❌ no support
* 🌅️ discontinued
* ⚠️ experimental

| Version | PHP 5.6 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 |
| ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| ^2.6    | 🌅️      | 🌅️      | ❌      | ❌      | ❌️      | ❌      |
| ^3.1    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^4.1    | ❌      | ❌      | ❌      | ✅️      | ✅️      | ⚠️      |

### OroCommerce

#### Community Edition

* ✅ available
* ❌ no support
* 🌅️ discontinued
* ⚠️ experimental

| Version | PHP 5.6 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 |
| ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| ^1.6    | 🌅️      | 🌅️      | ❌      | ❌      | ❌️      | ❌      |
| ^3.1    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^4.1    | ❌      | ❌      | ❌      | ✅️      | ✅️      | ⚠️      |

#### Enterprise Edition

* ✅ available
* ❌ no support
* 🌅️ discontinued
* ⚠️ experimental

| Version | PHP 5.6 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 |
| ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| ^1.6    | 🌅️      | 🌅️      | ❌      | ❌      | ❌️      | ❌      |
| ^3.1    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^4.1    | ❌      | ❌      | ❌      | ✅️      | ✅️      | ⚠️      |

### Marello

#### Community Edition

* ✅ available
* ❌ no support
* 🌅️ discontinued
* ⚠️ experimental

| Version | PHP 5.6 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 |
| ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| ^1.5    | 🌅️      | 🌅️      | ❌      | ❌      | ❌️      | ❌      |
| ^1.6    | 🌅️      | 🌅️      | ❌      | ❌      | ❌️      | ❌      |
| ^2.0    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^2.1    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^2.2    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^3.0    | ❌      | ❌      | ❌      | ✅️      | ✅️      | ⚠️      |

#### Enterprise Edition

* ✅ available
* ❌ no support
* 🌅️ discontinued
* ⚠️ experimental

| Version | PHP 5.6 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 |
| ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| ^1.5    | 🌅️      | 🌅️      | ❌      | ❌      | ❌️      | ❌      |
| ^1.6    | 🌅️      | 🌅️      | ❌      | ❌      | ❌️      | ❌      |
| ^2.0    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^2.1    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^2.2    | ❌      | ✅      | ✅      | ⚠️      | ⚠️      | ⚠️      |
| ^3.0    | ❌      | ❌      | ❌      | ✅️      | ✅️      | ⚠️      |

### Middleware

#### Community Edition

* ✅ available
* ❌ no support
* 🌅️ discontinued
* ⚠️ experimental

| Version | PHP 5.6 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 |
| ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| ^1.0    | ❌      | ❌      | ❌      | ❌️      | ✅️      | ⚠️      |

#### Enterprise Edition

* ✅ available
* ❌ no support
* 🌅️ discontinued
* ⚠️ experimental

| Version | PHP 5.6 | PHP 7.1 | PHP 7.2 | PHP 7.3 | PHP 7.4 | PHP 8.0 |
| ------- | ------- | ------- | ------- | ------- | ------- | ------- |
| ^1.0    | ❌      | ❌      | ❌      | ❌️      | ✅️      | ⚠️      |
