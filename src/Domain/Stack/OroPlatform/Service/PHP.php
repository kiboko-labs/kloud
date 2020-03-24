<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\OroPlatform\Service;

use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use Kiboko\Cloud\Domain\Stack\Compose\Volume;
use Kiboko\Cloud\Domain\Stack\DTO;
use Kiboko\Cloud\Domain\Stack\DTO\Context;
use Kiboko\Cloud\Domain\Stack\OroPlatform\FilesAwareTrait;
use Kiboko\Cloud\Domain\Stack\ServiceBuilderInterface;

final class PHP implements ServiceBuilderInterface
{
    use FilesAwareTrait;

    /** @var iterable|ServiceBuilderInterface[] */
    private iterable $delegated;
    private string $stacksPath;

    public function __construct(string $stacksPath, ServiceBuilderInterface ...$delegated)
    {
        $this->stacksPath = $stacksPath;
        $this->delegated = $delegated;
    }

    public function matches(Context $context): bool
    {
        foreach ($this->delegated as $delegated) {
            if ($delegated->matches($context)) {
                return true;
            }
        }

        return false;
    }

    public function build(DTO\Stack $stack, Context $context): DTO\Stack
    {
        foreach ($this->delegated as $delegated) {
            $delegated->build($stack, $context);
        }

        $stack->addVolumes(
            new Volume('composer', [
                'driver' => 'local',
                'driver_opts' => [
                    'type' => 'tmpfs',
                    'device' => 'tmpfs',
                    'o' => 'size=2048m,uid=1000,gid=1000',
                ],
            ]),
            new Volume('assets', [
                'driver' => 'local',
                'driver_opts' => [
                    'type' => 'tmpfs',
                    'device' => 'tmpfs',
                    'o' => 'size=2048m,uid=1000,gid=1000',
                ],
            ]),
            new Volume('cache', [
                'driver' => 'local',
                'driver_opts' => [
                    'type' => 'tmpfs',
                    'device' => 'tmpfs',
                    'o' => 'size=2048m,uid=1000,gid=1000',
                ],
            ]),
            );

        $stack->addEnvironmentVariables(
            new EnvironmentVariable(new Variable('COMPOSER_AUTH'), '{"github-oauth":{"github.com":"0000000000000000000000000000000000000000"},"bitbucket-oauth":{"bitbucket.org":{"consumer-key":"0000000000000000000000000000000000000000","consumer-secret":"0000000000000000000000000000000000000000"}}}'),
            new EnvironmentVariable(new Variable('COMPOSER_PROCESS_TIMEOUT'), 3000),
            );

        if ($context->withBlackfire) {
            $stack->addEnvironmentVariables(
                new EnvironmentVariable(new Variable('BLACKFIRE_CLIENT_ID'), '0000000000000000000000000000000000000000'),
                new EnvironmentVariable(new Variable('BLACKFIRE_CLIENT_TOKEN'), '0000000000000000000000000000000000000000'),
                new EnvironmentVariable(new Variable('BLACKFIRE_SERVER_ID'), '0000000000000000000000000000000000000000'),
                new EnvironmentVariable(new Variable('BLACKFIRE_SERVER_TOKEN'), '0000000000000000000000000000000000000000'),
                );
        }

        return $stack;
    }
}