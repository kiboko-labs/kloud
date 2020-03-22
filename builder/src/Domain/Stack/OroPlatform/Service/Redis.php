<?php declare(strict_types=1);

namespace Builder\Domain\Stack\OroPlatform\Service;

use Builder\Domain\Stack\Compose\EnvironmentVariable;
use Builder\Domain\Stack\Compose\PortMapping;
use Builder\Domain\Stack\Compose\Service;
use Builder\Domain\Stack\Compose\Variable;
use Builder\Domain\Stack\DTO;
use Builder\Domain\Stack\OroPlatform\FilesAwareTrait;
use Builder\Domain\Stack\ServiceBuilderInterface;

final class Redis implements ServiceBuilderInterface
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
            (new Service('redis'))
                ->setBuildContext('.docker/redis@5/')
                ->addPorts(
                    new PortMapping(new Variable('REDIS_PORT'), 6379)
                )
                ->setRestartOnFailure(),
        );

        $stack->addFiles(
            $this->findFilesToCopy($context, '.docker/redis@5/Dockerfile'),
            $this->findFilesToCopy($context, '.docker/redis@5/redis.conf'),
        );

        $stack->addEnvironmentVariables(
            new EnvironmentVariable(new Variable('REDIS_PORT')),
        );

        return $stack;
    }
}