<?php declare(strict_types=1);

namespace Builder\Domain\Stack\OroPlatform\Service\PHP;

use Builder\Domain\Stack\Compose\Service;
use Builder\Domain\Stack\DTO;
use Builder\Domain\Stack\OroPlatform\FilesAwareTrait;
use Builder\Domain\Stack\ServiceBuilderInterface;

final class MessageQueue implements ServiceBuilderInterface
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
            (new Service('mq'))
                ->extendsService('sh')
                ->setUser('docker', 'docker')
                ->setCommand( 'bin/console', 'oro:message-queue:consume', '--env=prod', '-vv')
                ->setRestartOnFailure(),
        );

        return $stack;
    }
}