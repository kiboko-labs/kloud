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
                ->setBuildContext('.docker/rabbitmq@3.9')
                ->addEnvironmentVariables(
                    new EnvironmentVariable(new Variable('RABBITMQ_DEFAULT_USER'), new Variable('RABBITMQ_USER')),
                    new EnvironmentVariable(new Variable('RABBITMQ_DEFAULT_PASS'), new Variable('RABBITMQ_PASSWORD')),
                )
                ->addPorts(
                    new PortMapping(new Variable('RABBITMQ_PORT'), 15672)
                )
                ->setRestartOnFailure(),
        );

        $stack->addFiles(
            new Resource\InMemory('.docker/rabbitmq@3.9/Dockerfile', <<<EOF
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
                EOF),
        );

        $stack->addEnvironmentVariables(
            new EnvironmentVariable(new Variable('RABBITMQ_PORT')),
            new EnvironmentVariable(new Variable('RABBITMQ_USER'), 'rabbitmq'),
            new EnvironmentVariable(new Variable('RABBITMQ_PASSWORD'), 'password'),
        );

        return $stack;
    }
}