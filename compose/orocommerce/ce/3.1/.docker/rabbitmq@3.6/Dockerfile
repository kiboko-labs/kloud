FROM rabbitmq:3.7-management-alpine

RUN set -ex\
    && apk update \
    && apk upgrade \
    && apk add --no-cache --virtual .build-deps \
        zip \
        curl \
    && curl https://dl.bintray.com/rabbitmq/community-plugins/3.7.x/rabbitmq_delayed_message_exchange/rabbitmq_delayed_message_exchange-20171201-3.7.x.zip > $RABBITMQ_HOME/plugins/rabbitmq_delayed_message_exchange-20171201-3.7.x.zip \
    && unzip $RABBITMQ_HOME/plugins/rabbitmq_delayed_message_exchange-20171201-3.7.x.zip -d $RABBITMQ_HOME/plugins \
    && rm $RABBITMQ_HOME/plugins/rabbitmq_delayed_message_exchange-20171201-3.7.x.zip \
    && apk del .build-deps

RUN rabbitmq-plugins enable --offline rabbitmq_delayed_message_exchange
RUN rabbitmq-plugins enable --offline rabbitmq_consistent_hash_exchange

