<?php declare(strict_types=1);

namespace Builder\Domain\Stack\OroPlatform;

use Builder\Domain\Stack\Compose\EnvironmentVariable;
use Builder\Domain\Stack\Compose\Stack;
use Builder\Domain\Stack\Compose\Variable;
use Builder\Domain\Stack\DelegatedStackBuilderInterface;
use Builder\Domain\Stack\DTO;
use Builder\Domain\Stack\OroPlatform\Service;
use Builder\Domain\Stack\ServiceBuilderInterface;

final class Builder implements DelegatedStackBuilderInterface
{
    private string $stacksPath;
    /** @var iterable|ServiceBuilderInterface[] */
    private iterable $serviceBuilders;

    public function __construct(string $stacksPath)
    {
        $this->stacksPath = $stacksPath;

        $this->serviceBuilders = [
            new Service\Mailcatcher($stacksPath),
            new Service\RabbitMQ($stacksPath),
            new Service\Redis($stacksPath),
            new Service\ElasticSearch($stacksPath),
            new Service\MySQL($stacksPath),
            new Service\PostgreSQL($stacksPath),
            new Service\Nginx($stacksPath),
            new Service\PHP(
                $stacksPath,
                new Service\PHP\FPM($stacksPath),
                new Service\PHP\FPMWithXdebug($stacksPath),
                new Service\PHP\CLI($stacksPath),
                new Service\PHP\CLIWithXdebug($stacksPath),
                new Service\PHP\Blackfire($stacksPath),
                new Service\PHP\MessageQueue($stacksPath),
                new Service\PHP\Websocket($stacksPath),
            )
        ];
    }

    public function matches(DTO\Context $context): bool
    {
        return in_array($context->application, ['orocommerce', 'orocrm', 'oroplatform', 'marello'], true);
    }

    public function build(DTO\Context $context): DTO\Stack
    {
        $stack = new DTO\Stack($context, new Stack('2.2'));

        $stack->addEnvironmentVariables(
            new EnvironmentVariable(new Variable('APPLICATION_DOMAIN'))
        );

        foreach ($this->serviceBuilders as $serviceBuilder) {
            if (!$serviceBuilder->matches($context)) {
                continue;
            }

            $serviceBuilder->build($stack, $context);
        }

        return $stack;
    }
}