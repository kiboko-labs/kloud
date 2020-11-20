Frequently Asked Questions
===

I am having some warnings while launching `docker-compose up` for the first time
---

If you are having this sort of messages:

```
WARNING: The MAILCATCHER_PORT variable is not set. Defaulting to a blank string.
ERROR: The Compose file './docker-compose.yml' is invalid because:
services.mail.ports contains an invalid type, it should be a number, or an object
```

Those warnings and errors are due to missing environment variables, probably because you did 
not copy the `.env.dist` file to a `.env` file, or you juste made a `stack:upgrade` and some
new environment variables are required.

What is the use of the `I_AM_DEVELOPER_DISABLE_INDEX_IP_CHECK` environment variable?
---

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

How to access My application's frontend?
---

The application frontend can be accessed through the port defined in the `HTTP_PORT`
environment variable value.

How to switch between dev/prod/xdebug environments? (experimental)
---

We have built a [Firefox/Chrome plugin](https://github.com/kiboko-labs/kiboko-symfony-env) to help you switch between environments.

This extension is currently experimental and is limited to [a few domain names](https://github.com/kiboko-labs/kiboko-symfony-env#supported-domains). It may fit your needs as is, but be aware that you may need to manually package the extension if you need other domain names.

![Capture of the plugin in action](https://github.com/kiboko-labs/kiboko-symfony-env/raw/master/screenshot.png)

How to configure the mailer in the `parameters.yml` file?
---

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

How to configure the websocket service in the `parameters.yml` file?
---

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

How to configure the database service in the `parameters.yml` file?
---

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

How to configure the search engine service in the `parameters.yml` file?
---

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

How to configure the message queue service in the `parameters.yml` file?
---

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

How to enable ElasticStack logging
---

To integrate ElasticStack in your monolog config, you will need to change your `config/config_dev.yml` file, as such:

```yaml
services:
    monolog.formatters.logstash:
        class: Monolog\Formatter\LogstashFormatter
        arguments:
            $applicationName: 'your application'
monolog:
    handlers:
        logstash:
            type: socket
            connection_string: 'tcp://logstash:5044'
            level: debug
            formatter: monolog.formatters.logstash
            persistent: true
            connection_timeout: 5
```

How to access to Mailcatcher's interface?
---

The Mailcatcher interface can be accessed through the port defined in the `MAILCATCHER_PORT`
environment variable value.

How to access RabbitMQ manager's interface?
---

The RabbitMQ manager interface can be accessed through the port defined in the `RABBITMQ_PORT`
environment variable value.

How to access Dejavu's interface for Elasticsearch?
---

The Dejavu interface can be accessed through the port defined in the `DEJAVU_PORT`
environment variable value.

Additionnally, the `ELASTICSEARCH_PORT` variable should be defined in order to make
Elasticsearch's API accessible from your computer.

How to access Elasticsearch's API?
---

The Elasticsearch API can be accessed through the port defined in the `ELASTICSEARCH_PORT`
environment variable value.

How to access Kibana's interface?
---

The Kibana interface can be accessed through the port defined in the `KIBANA_PORT`
environment variable value.

How to access Redis service from your computer?
---

The Redis servcie can be accessed through the port defined in the `REDIS_PORT`
environment variable value.

How to access MySQL or PostgreSQL service from your computer?
---

The MySQL or PostgreSQL servcie can be accessed through the port defined in the `DATABASE_PORT`
environment variable value.
