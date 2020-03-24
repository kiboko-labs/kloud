<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\OroPlatform\Service;

use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\PortMapping;
use Kiboko\Cloud\Domain\Stack\Compose\Service;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use Kiboko\Cloud\Domain\Stack\DTO;
use Kiboko\Cloud\Domain\Stack\OroPlatform\FilesAwareTrait;
use Kiboko\Cloud\Domain\Stack\ServiceBuilderInterface;

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