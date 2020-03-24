<?php declare(strict_types=1);

namespace Builder\Domain\Stack\OroPlatform\Service\PHP;

use Builder\Domain\Stack\Compose\EnvironmentVariable;
use Builder\Domain\Stack\Compose\PortMapping;
use Builder\Domain\Stack\Compose\Service;
use Builder\Domain\Stack\Compose\Variable;
use Builder\Domain\Stack\DTO;
use Builder\Domain\Stack\OroPlatform\FilesAwareTrait;
use Builder\Domain\Stack\ServiceBuilderInterface;

final class Websocket implements ServiceBuilderInterface
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