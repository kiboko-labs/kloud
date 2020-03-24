<?php declare(strict_types=1);

namespace Builder\Domain\Stack\OroPlatform\Service;

use Builder\Domain\Stack\Compose\EnvironmentVariable;
use Builder\Domain\Stack\Compose\PortMapping;
use Builder\Domain\Stack\Compose\Service;
use Builder\Domain\Stack\Compose\Variable;
use Builder\Domain\Stack\DTO;
use Builder\Domain\Stack\OroPlatform\FilesAwareTrait;
use Builder\Domain\Stack\ServiceBuilderInterface;

final class RabbitMQ implements ServiceBuilderInterface
{
    use FilesAwareTrait;

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
            $this->findFilesToCopy($context, '.docker/rabbitmq@3.6/Dockerfile'),
        );

        $stack->addEnvironmentVariables(
            new EnvironmentVariable(new Variable('RABBITMQ_PORT')),
        );

        return $stack;
    }
}