<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\OroPlatform\Service\PHP;

use Kiboko\Cloud\Domain\Stack\Compose\Service;
use Kiboko\Cloud\Domain\Stack\DTO;
use Kiboko\Cloud\Domain\Stack\ServiceBuilderInterface;

final class MessageQueue implements ServiceBuilderInterface
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
            (new Service('mq'))
                ->extendsService('sh')
                ->setUser('docker', 'docker')
                ->setCommand( 'bin/console', 'oro:message-queue:consume', '--env=prod', '-vv')
                ->setRestartOnFailure(),
        );

        return $stack;
    }
}