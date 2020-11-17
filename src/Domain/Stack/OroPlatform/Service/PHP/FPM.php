<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\OroPlatform\Service\PHP;

use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\InheritedEnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\Service;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use Kiboko\Cloud\Domain\Stack\Compose\VolumeMapping;
use Kiboko\Cloud\Domain\Stack\DTO;
use Kiboko\Cloud\Domain\Stack\ServiceBuilderInterface;

final class FPM implements ServiceBuilderInterface
{
    private string $stacksPath;

    public function __construct(string $stacksPath)
    {
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
                'kiboko/php:%s-fpm-blackfire-%s-%s-%s-%s',
                $context->phpVersion,
                $context->application,
                $context->isEnterpriseEdition ? 'ee' : 'ce',
                $context->applicationVersion,
                $context->dbms
            );
        }

        return sprintf(
            'kiboko/php:%s-fpm-%s-%s-%s-%s',
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
            new EnvironmentVariable(new Variable('I_AM_DEVELOPER_DISABLE_INDEX_IP_CHECK')),
        ];
        if ($context->withBlackfire) {
            array_push(
                $environment,
                new InheritedEnvironmentVariable(new Variable('BLACKFIRE_CLIENT_ID')),
                new InheritedEnvironmentVariable(new Variable('BLACKFIRE_CLIENT_TOKEN')),
            );
        }

        $stack->addServices(
            ($service = new Service('fpm', $this->buildImageTag($context)))
                ->setUser('docker', 'docker')
                ->addEnvironmentVariables(...$environment)
                ->addVolumeMappings(
                    new VolumeMapping('./', '/var/www/html'),
                )
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