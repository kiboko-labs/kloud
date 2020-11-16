<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\OroPlatform\Service\PHP;

use Kiboko\Cloud\Domain\Packaging\RepositoryInterface;
use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\PortMapping;
use Kiboko\Cloud\Domain\Stack\Compose\Service;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use Kiboko\Cloud\Domain\Stack\DTO;
use Kiboko\Cloud\Domain\Stack\ServiceBuilderInterface;

final class Websocket implements ServiceBuilderInterface
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

    public function build(DTO\Stack $stack, DTO\Context $context): DTO\Stack
    {
        $stack->addServices(
            (new Service('ws'))
                ->extendsService('sh')
                ->setUser('docker', 'docker')
                ->setCommand( 'bin/console', 'gos:websocket:server', '--env=prod', '-vv')
                ->addPorts(
                    new PortMapping(new Variable('WEBSOCKET_PORT'), 8080),
                )
                ->setRestartOnFailure(),
        );

        $stack->addEnvironmentVariables(
            new EnvironmentVariable(new Variable('WEBSOCKET_PORT')),
            );

        return $stack;
    }
}
