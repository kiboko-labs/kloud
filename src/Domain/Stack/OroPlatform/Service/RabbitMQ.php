<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\OroPlatform\Service;

use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\PortMapping;
use Kiboko\Cloud\Domain\Stack\Compose\Service;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use Kiboko\Cloud\Domain\Stack\DTO;
use Kiboko\Cloud\Domain\Stack\Resource;
use Kiboko\Cloud\Domain\Stack\ServiceBuilderInterface;

final class RabbitMQ implements ServiceBuilderInterface
{
    private string $stacksPath;

    public function __construct(string $stacksPath)
    {
        $this->stacksPath = $stacksPath;
    }

    public function matches(DTO\Context $context): bool
    {
        return $context->isEnterpriseEdition === true;
    }

    public function build(DTO\Stack $stack, DTO\Context $context): DTO\Stack
    {
        $stack->addServices(
            (new Service('amqp'))
                ->setBuildContext('.docker/rabbitmq@3.6')
                ->addEnvironmentVariables(
                    new EnvironmentVariable(new Variable('RABBITMQ_DEFAULT_USER'), 'kiboko'),
                    new EnvironmentVariable(new Variable('RABBITMQ_DEFAULT_PASS'), 'password'),
                )
                ->addPorts(
                    new PortMapping(new Variable('RABBITMQ_PORT'), 15672)
                )
                ->setRestartOnFailure(),
        );

        $stack->addFiles(
            new Resource\InMemory('.docker/rabbitmq@3.6/Dockerfile', <<<EOF
                FROM rabbitmq:3.7-management-alpine

                RUN set -ex\
                    && apk update \
                    && apk upgrade \
                    && apk add --no-cache --virtual .build-deps \
                        zip \
                        curl \
                    && curl https://dl.bintray.com/rabbitmq/community-plugins/3.7.x/rabbitmq_delayed_message_exchange/rabbitmq_delayed_message_exchange-20171201-3.7.x.zip > \$RABBITMQ_HOME/plugins/rabbitmq_delayed_message_exchange-20171201-3.7.x.zip \
                    && unzip \$RABBITMQ_HOME/plugins/rabbitmq_delayed_message_exchange-20171201-3.7.x.zip -d \$RABBITMQ_HOME/plugins \
                    && rm \$RABBITMQ_HOME/plugins/rabbitmq_delayed_message_exchange-20171201-3.7.x.zip \
                    && apk del .build-deps
                
                RUN rabbitmq-plugins enable --offline rabbitmq_delayed_message_exchange
                RUN rabbitmq-plugins enable --offline rabbitmq_consistent_hash_exchange
                EOF),
        );

        $stack->addEnvironmentVariables(
            new EnvironmentVariable(new Variable('RABBITMQ_PORT')),
        );

        return $stack;
    }
}