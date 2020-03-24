<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\OroPlatform\Service;

use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\PortMapping;
use Kiboko\Cloud\Domain\Stack\Compose\Service;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use Kiboko\Cloud\Domain\Stack\DTO;
use Kiboko\Cloud\Domain\Stack\OroPlatform\FilesAwareTrait;
use Kiboko\Cloud\Domain\Stack\ServiceBuilderInterface;

final class Mailcatcher implements ServiceBuilderInterface
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
            (new Service('mail', 'schickling/mailcatcher:latest'))
                ->addPorts(
                    new PortMapping(new Variable('MAILCATCHER_PORT'), 1080),
                )
                ->setRestartOnFailure()
            )
        ;

        $stack->addEnvironmentVariables(
            new EnvironmentVariable(new Variable('MAILCATCHER_PORT')),
        );

        return $stack;
    }
}