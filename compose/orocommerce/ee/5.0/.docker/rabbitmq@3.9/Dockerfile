FROM rabbitmq:3.9-management-alpine

RUN set -ex\
    && apk update \
    && apk upgrade \
    && apk add --no-cache --virtual .build-deps \
        zip \
        curl \
    && m -f /etc/rabbitmq/conf.d/management_agent.disable_metrics_collector.conf; \
    && cp /plugins/rabbitmq_management-*/priv/www/cli/rabbitmqadmin /usr/local/bin/rabbitmqadmin; \
    && [ -s /usr/local/bin/rabbitmqadmin ]; \
    && chmod +x /usr/local/bin/rabbitmqadmin; \
    && apk add --no-cache python3; \
    && rabbitmqadmin --version
    && apk del .build-deps

RUN rabbitmq-plugins enable --offline rabbitmq_delayed_message_exchange
RUN rabbitmq-plugins enable --offline rabbitmq_consistent_hash_exchange
RUN rabbitmq-plugins enable --offline rabbitmq_management