<?php declare(strict_types=1);

namespace Builder\Domain\Stack\OroPlatform\Service\PHP;

use Builder\Domain\Stack\Compose\InheritedEnvironmentVariable;
use Builder\Domain\Stack\Compose\Service;
use Builder\Domain\Stack\Compose\Variable;
use Builder\Domain\Stack\DTO;
use Builder\Domain\Stack\OroPlatform\FilesAwareTrait;
use Builder\Domain\Stack\ServiceBuilderInterface;

final class Blackfire implements ServiceBuilderInterface
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
            (new Service('blackfire', 'blackfire/blackfire'))
                ->addEnvironmentVariables(
                    new InheritedEnvironmentVariable(new Variable('BLACKFIRE_SERVER_ID')),
                    new InheritedEnvironmentVariable(new Variable('BLACKFIRE_SERVER_TOKEN')),
                )
                ->setRestartOnFailure(),
            )
        ;

        return $stack;
    }
}