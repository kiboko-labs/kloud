Foire aux questions
===

Table des matières
---

 * [Comment installer une version spécifique de Kloud ?](#how-to-install-a-specific-version)
 * [Comment changer la configuration de ma stack ?](#how-to-change-my-stacks-configuration)
 * [Lorsque je lance docker-compose up pour la première fois, je reçois des avertissements](#i-am-having-some-warnings-while-launching-docker-compose-up-for-the-first-time)
 * [Quelle est l’utilité de la variable d’environnement I_AM_DEVELOPER_DISABLE_INDEX_IP_CHECK ?](#what-is-the-use-of-the-i_am_developer_disable_index_ip_check-environment-variable)
 * [Comment accéder à l’interface de mon application ?](#how-to-access-my-applications-frontend)
 * [Comment basculer entre les environnements dev/prod/xdebug ? (expérimental)](#how-to-switch-between-devprodxdebug-environments-experimental)
 * [Comment configurer mailer dans le fichier parameters.yml ?](#how-to-configure-the-mailer-in-the-parametersyml-file)
 * [Comment configurer le service websocket dans le fichier parameters.yml ?](#how-to-configure-the-websocket-service-in-the-parametersyml-file)
 * [Comment configurer le service de base de données dans le fichier parameters.yml ?](#how-to-configure-the-database-service-in-the-parametersyml-file)
 * [Comment configurer le service des moteurs de recherche dans le fichier parameters.yml ?](#how-to-configure-the-search-engine-service-in-the-parametersyml-file)
 * [Comment configurer le service de la message queue dans le fichier parameters.ym l?](#how-to-configure-the-message-queue-service-in-the-parametersyml-file)
 * [Comment activer la journalisation ElasticStack ?](#how-to-enable-elasticstack-logging)
 * [Comment accéder à l’interface de Mailcatcher ?](#how-to-access-to-mailcatchers-interface)
 * [Comment accéder à l’interface du gestionnaire RabbitMQ ?](#how-to-access-rabbitmq-managers-interface)
 * [Comment accéder à l’interface de Dejavu pour Elasticsearch ?](#how-to-access-dejavus-interface-for-elasticsearch)
 * [Comment accéder à l’API d’Elasticsearch ?](#how-to-access-elasticsearchs-api)
 * [Comment accéder à l’interface de Kibana ?](#how-to-access-kibanas-interface)
 * [Comment accéder au service Redis depuis votre ordinateur ?](#how-to-access-redis-service-from-your-computer)
 * [Comment accéder au service MySQL ou PostgreSQL depuis votre ordinateur ?](#how-to-access-mysql-or-postgresql-service-from-your-computer)

 -----------------
Comment installer une version spécifique de Kloud ?
---

Les versions disponibles sont : 1.0, 1.1 et 1.2

Exemple pour 1.2.2

```
sudo curl -L -o /usr/local/bin/kloud https://github.com/kiboko-labs/kloud/releases/download/1.2.2/kloud.phar
sudo curl -L -o /usr/local/bin/kloud.pubkey https://github.com/kiboko-labs/kloud/releases/download/1.2.2/kloud.phar.pubkey
sudo chmod +x /usr/local/bin/kloud
```

Comment changer la configuration de ma stack ?
---

```
kloud stack:upgrade
```

Lorsque je lance `docker-compose up` pour la première fois, je reçois des avertissements
---

Si vous avez ce genre de messages :

```
WARNING: The MAILCATCHER_PORT variable is not set. Defaulting to a blank string.
ERROR: The Compose file './docker-compose.yml' is invalid because:
services.mail.ports contains an invalid type, it should be a number, or an object
```

Ces avertissements et erreurs sont dus à des variables d’environnement manquantes, 
probablement parce que vous n’avez pas copié le fichier .env.dist 
dans un fichier `.env`, ou que vous avez simplement fait une `pile:upgrade` et que de nouvelles variables d’environnement sont nécessaires.

Quelle est l’utilité de la variable d’environnement `I_AM_DEVELOPER_DISABLE_INDEX_IP_CHECK` ?
---

Cette variable d’environnement est utilisée pour désactiver le contrôle IP dans le fichier `public/index_dev.php`.
Pour bénéficier de cette fonctionnalité, vous devrez appliquer le patch suivant : 

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

Comment accéder à l’interface de mon application ?
---

L’interface de l’application est accessible via le port défini dans la variable d’environnement `HTTP_PORT`.

Comment basculer entre les environnements dev/prod/xdebug ? (expérimental)
---

Nous avons créé un [plugin Firefox/Chrome](https://github.com/kiboko-labs/kiboko-symfony-env) pour vous aider à passer d’un environnement à l’autre.

Cette extension est actuellement expérimentale et est limitée à [quelques noms de domaine](https://github.com/kiboko-labs/kiboko-symfony-env#supported-domains). Il peut répondre à vos besoins tels quels, mais sachez que vous devrez peut-être empaqueter manuellement l’extension si vous avez besoin d’autres noms de domaine.

![Capture of the plugin in action](https://github.com/kiboko-labs/kiboko-symfony-env/raw/master/screenshot.png)

Comment configurer mailer dans le fichier `parameters.yml`?
---

Les paramètres doivent être définis comme suit :

```yaml
parameters:
    mailer_transport: smtp
    mailer_host: mail
    mailer_port: 1025
    mailer_encryption: null
    mailer_user: null
    mailer_password: null
```

Notez que la variable `MAILER_PORT` n’est pas utilisée car ce port est celui de votre machine, pas celui d’un container dans la stack.

Comment configurer le service websocket dans le fichier `parameters.yml`?
---

Les paramètres doivent être définis comme suit sur Oro 4.1+ :

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
Notez que la variable `WEBSOCKET_PORT` n’est pas utilisée car ce port est celui de votre machine, pas celui d’un container dans la stack.

Comment configurer le service de base de données dans le fichier `parameters.yml`?
---

Les paramètres doivent être définis comme suit sur Oro 4.1+ :

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

Notez que la variable `DATABASE_PORT` n’est pas utilisée car ce port est celui de votre machine, pas celui d’un container dans la stack.

Comment configurer le service des moteurs de recherche dans le fichier `parameters.yml` ?
---

Les paramètres doivent être définis comme suit :

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

Notez que la variable `ELASTICSEARCH_PORT` n’est pas utilisée car ce port est celui de votre machine, pas celui d’un container dans la stack.

Comment configurer le service de la message queue dans le fichier `parameters.yml`?
---

Les paramètres doivent être définis comme suit :

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

Notez que la variable `ELASTICSEARCH_PORT` n’est pas utilisée car ce port est celui de votre machine, pas celui d’un container dans la stack.

Comment activer la journalisation ElasticStack ?
---

Pour intégrer ElasticStack dans votre configuration monolog, vous devrez modifier votre fichier `config/config_dev.yml`, par exemple :

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

Comment accéder à l’interface de Mailcatcher ?
---

L’interface Mailcatcher est accessible via le port `MAILCATCHER_PORT` défini dans les variables d’environnement.

Comment accéder à l’interface du gestionnaire RabbitMQ ?
---

L’interface du gestionnaire RabbitMQ est accessible par le port `RABBITMQ_PORT` défini dans les variables d'environement.

Comment accéder à l’interface de Dejavu pour Elasticsearch ?
---

L’interface Dejavu est accessible via le port `DEJAVU_PORT` défini dans les variables d’environnement.

De plus, la variable `ELASTICSEARCH_PORT` doit être défini afin de rendre l'API d'Elasticsearch accessible depuis votre ordinateur.

Comment accéder à l’API d’Elasticsearch ?
---

L'API d'Elasticsearch est accessible via le port `ELASTICSEARCH_PORT` défini dans les variables d’environnement.

Comment accéder à l’interface de Kibana ?
---

L'Interface Kibana est accessible via le port `KIBANA_PORT` défini dans les variables d’environnement.

Comment accéder au service Redis depuis votre ordinateur ?
---

Le service Redis est accessible via le port `REDIS_PORT` défini dans les variables d’environnement.

Comment accéder au service MySQL ou PostgreSQL depuis votre ordinateur ?
---

Le service MySQL ou PostgreSQL est accessible via le port `DATABASE_PORT` défini dans les variables d’environnement.
