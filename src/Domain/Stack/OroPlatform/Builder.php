<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\OroPlatform;

use Kiboko\Cloud\Domain\Packaging\RepositoryInterface;
use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\Stack;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use Kiboko\Cloud\Domain\Stack\DelegatedStackBuilderInterface;
use Kiboko\Cloud\Domain\Stack\DTO;
use Kiboko\Cloud\Domain\Stack\OroPlatform\Service;
use Kiboko\Cloud\Domain\Stack\ServiceBuilderInterface;
use Kiboko\Cloud\Domain\Stack\UnprocessableVersionConstraintsException;

final class Builder implements DelegatedStackBuilderInterface
{
    private string $stacksPath;
    /** @var iterable|ServiceBuilderInterface[] */
    private iterable $serviceBuilders;

    public function __construct(
        RepositoryInterface $phpRepository,
        string $stacksPath
    ) {
        $this->stacksPath = $stacksPath;

        $this->serviceBuilders = [
            new Service\Mailcatcher($stacksPath),
            new Service\RabbitMQ($stacksPath),
            new Service\Redis($stacksPath),
            new Service\ElasticSearch($stacksPath),
            new Service\Kibana($stacksPath),
            new Service\Logstash($stacksPath),
            new Service\MySQL($stacksPath),
            new Service\PostgreSQL($stacksPath),
            new Service\Nginx($stacksPath),
            new Service\PHP(
                $stacksPath,
                new Service\PHP\FPM($phpRepository, $stacksPath),
                new Service\PHP\FPMWithXdebug($phpRepository, $stacksPath),
                new Service\PHP\CLI($phpRepository, $stacksPath),
                new Service\PHP\CLIWithXdebug($phpRepository, $stacksPath),
                new Service\PHP\Blackfire($stacksPath),
                new Service\PHP\MessageQueue($stacksPath),
                new Service\PHP\Websocket($stacksPath),
            )
        ];
    }

    public function matches(DTO\Context $context): bool
    {
        return in_array($context->application, ['orocommerce', 'orocrm', 'oroplatform', 'marello', 'middleware'], true);
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

            try {
                $serviceBuilder->build($stack, $context);
            } catch (Service\StackServiceNotApplicableException $exception) {
                throw new UnprocessableVersionConstraintsException(
                    'One of the required services could not be applied to these versions constraints.',
                    0,
                    $exception
                );
            }
        }

        return $stack;
    }
}
