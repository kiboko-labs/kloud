<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\OroPlatform\Service\PHP;

use Kiboko\Cloud\Domain\Packaging\RepositoryInterface;
use Kiboko\Cloud\Domain\Stack\Compose\InheritedEnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\Service;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use Kiboko\Cloud\Domain\Stack\Compose\VolumeMapping;
use Kiboko\Cloud\Domain\Stack\DTO;
use Kiboko\Cloud\Domain\Stack\ServiceBuilderInterface;

final class CLI implements ServiceBuilderInterface
{
    private RepositoryInterface $repository;
    private string $stacksPath;

    public function __construct(RepositoryInterface $phpRepository, string $stacksPath)
    {
        $this->repository = $phpRepository;
        $this->stacksPath = $stacksPath;
    }

    public function matches(DTO\Context $context): bool
    {
        return true;
    }

    private function buildImageTag(DTO\Context $context): string
    {
        if ($context->withBlackfire) {
            return sprintf(
                '%s:%s-cli-blackfire-%s-%s-%s-%s',
                $this->repository,
                $context->phpVersion,
                $context->application,
                $context->isEnterpriseEdition ? 'ee' : 'ce',
                $context->applicationVersion,
                $context->dbms
            );
        }

        return sprintf(
            '%s:%s-cli-%s-%s-%s-%s',
            $this->repository,
            $context->phpVersion,
            $context->application,
            $context->isEnterpriseEdition ? 'ee' : 'ce',
            $context->applicationVersion,
            $context->dbms
        );
    }

    public function build(DTO\Stack $stack, DTO\Context $context): DTO\Stack
    {
        $environment = [
            new InheritedEnvironmentVariable(new Variable('DATABASE_NAME')),
            new InheritedEnvironmentVariable(new Variable('DATABASE_USER')),
            new InheritedEnvironmentVariable(new Variable('DATABASE_PASSWORD')),
            new InheritedEnvironmentVariable(new Variable('WEBSOCKET_PORT')),
            new InheritedEnvironmentVariable(new Variable('RABBITMQ_USER')),
            new InheritedEnvironmentVariable(new Variable('RABBITMQ_PASSWORD')),
            new InheritedEnvironmentVariable(new Variable('COMPOSER_AUTH')),
            new InheritedEnvironmentVariable(new Variable('COMPOSER_PROCESS_TIMEOUT')),
        ];
        if ($context->withBlackfire) {
            array_push(
                $environment,
                new InheritedEnvironmentVariable(new Variable('BLACKFIRE_CLIENT_ID')),
                new InheritedEnvironmentVariable(new Variable('BLACKFIRE_CLIENT_TOKEN')),
            );
        }

        $stack->addServices(
            ($service = new Service('sh', $this->buildImageTag($context)))
                ->setUser('docker', 'docker')
                ->addEnvironmentVariables(...$environment)
                ->addVolumeMappings(
                    new VolumeMapping(new DTO\Concatenated(new Variable('HOME'), '/.ssh'), '/opt/docker/.ssh/'),
                    new VolumeMapping('./', '/var/www/html'),
                    new VolumeMapping('composer', '/opt/docker/.composer/'),
                )
                ->setCommand('sleep', '31536000')
                ->setRestartOnFailure(),
            );

        if ($context->withDockerForMacOptimizations === true) {
            $service->addVolumeMappings(
                new VolumeMapping('cache', '/var/www/html/var/cache'),
                new VolumeMapping('assets', '/var/www/html/public/bundles'),
            );
        }

        return $stack;
    }
}
