<?php declare(strict_types=1);

namespace Builder\Domain\Stack\OroPlatform\Service;

use Builder\Domain\Stack\Compose\EnvironmentVariable;
use Builder\Domain\Stack\Compose\PortMapping;
use Builder\Domain\Stack\Compose\Service;
use Builder\Domain\Stack\Compose\Variable;
use Builder\Domain\Stack\Compose\VolumeMapping;
use Builder\Domain\Stack\DTO;
use Builder\Domain\Stack\OroPlatform\FilesAwareTrait;
use Builder\Domain\Stack\ServiceBuilderInterface;

final class Nginx implements ServiceBuilderInterface
{
    use FilesAwareTrait;

    public function __construct(string $stacksPath)
    {
        $this->stacksPath = $stacksPath;
    }

    public function matches(DTO\Context $context): bool
    {
        return true;
    }

    public function build(DTO\Stack $stack, DTO\Context $context): DTO\Stack
    {
        $servicesDependency = ['http-worker-prod', 'http-worker-dev'];
        if ($context->withXdebug) {
            $servicesDependency[] = 'http-worker-xdebug';
        }

        $stack->addServices(
            (new Service('http', 'nginx:alpine'))
                ->addVolumeMappings(
                    new VolumeMapping('./.docker/nginx@1.15/config/options.conf', '/etc/nginx/conf.d/000-options.conf'),
                    new VolumeMapping('./.docker/nginx@1.15/config/reverse-proxy.conf', '/etc/nginx/conf.d/default.conf'),
                    new VolumeMapping('./', '/var/www/html'),
                    new VolumeMapping('cache', '/var/www/html/var/cache', true),
                    new VolumeMapping('assets', '/var/www/html/public/bundles', true),
                )
                ->addPorts(
                    new PortMapping(new Variable('HTTP_PORT'), 80),
                )
                ->setRestartOnFailure()
                ->addDependencies(...$servicesDependency),
            (new Service('http-worker-prod', 'nginx:alpine'))
                ->addVolumeMappings(
                    new VolumeMapping('./.docker/nginx@1.15/config/options.conf', '/etc/nginx/conf.d/000-options.conf'),
                    new VolumeMapping('./.docker/nginx@1.15/config/vhost-prod.conf', '/etc/nginx/conf.d/default.conf'),
                    new VolumeMapping('./', '/var/www/html'),
                    new VolumeMapping('cache', '/var/www/html/var/cache', true),
                    new VolumeMapping('assets', '/var/www/html/public/bundles', true),
                )
                ->addPorts(
                    new PortMapping(new Variable('HTTP_PROD_PORT'), 80),
                )
                ->setRestartOnFailure()
                ->addDependencies('fpm'),
            (new Service('http-worker-dev', 'nginx:alpine'))
                ->addVolumeMappings(
                    new VolumeMapping('./.docker/nginx@1.15/config/options.conf', '/etc/nginx/conf.d/000-options.conf'),
                    new VolumeMapping('./.docker/nginx@1.15/config/vhost-dev.conf', '/etc/nginx/conf.d/default.conf'),
                    new VolumeMapping('./', '/var/www/html'),
                    new VolumeMapping('cache', '/var/www/html/var/cache', true),
                    new VolumeMapping('assets', '/var/www/html/public/bundles', true),
                )
                ->addPorts(
                    new PortMapping(new Variable('HTTP_DEV_PORT'), 80),
                )
                ->setRestartOnFailure()
                ->addDependencies('fpm')
            );

        $stack->addFiles(
            $this->findFilesToCopy($context, '.docker/nginx@1.15/config/options.conf'),
            $this->findFilesToCopy($context, '.docker/nginx@1.15/config/reverse-proxy.conf'),
            $this->findFilesToCopy($context, '.docker/nginx@1.15/config/vhost-prod.conf'),
            $this->findFilesToCopy($context, '.docker/nginx@1.15/config/vhost-dev.conf'),
        );

        $stack->addEnvironmentVariables(
            new EnvironmentVariable(new Variable('HTTP_PORT')),
            new EnvironmentVariable(new Variable('HTTP_PROD_PORT')),
            new EnvironmentVariable(new Variable('HTTP_DEV_PORT')),
        );

        if ($context->withXdebug) {
            $stack->addServices(
                (new Service('http-worker-xdebug', 'nginx:alpine'))
                    ->addVolumeMappings(
                        new VolumeMapping('./.docker/nginx@1.15/config/options.conf', '/etc/nginx/conf.d/000-options.conf'),
                        new VolumeMapping('./.docker/nginx@1.15/config/vhost-xdebug.conf', '/etc/nginx/conf.d/default.conf'),
                        new VolumeMapping('./', '/var/www/html'),
                        new VolumeMapping('cache', '/var/www/html/var/cache', true),
                        new VolumeMapping('assets', '/var/www/html/public/bundles', true),
                        )
                    ->addPorts(
                        new PortMapping(new Variable('HTTP_XDEBUG_PORT'), 80),
                        )
                    ->setRestartOnFailure()
                    ->addDependencies('fpm-xdebug'),
            );
            $stack->addEnvironmentVariables(
                new EnvironmentVariable(new Variable('HTTP_XDEBUG_PORT')),
            );
            $stack->addFiles(
                $this->findFilesToCopy($context, '.docker/nginx@1.15/config/vhost-xdebug.conf'),
            );
        }

        return $stack;
    }
}