<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\OroPlatform\Service\PHP;

use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\PortMapping;
use Kiboko\Cloud\Domain\Stack\Compose\Service;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use Kiboko\Cloud\Domain\Stack\DTO;
use Kiboko\Cloud\Domain\Stack\DTO\Context;
use Kiboko\Cloud\Domain\Stack\ServiceBuilderInterface;

final class DBGP implements ServiceBuilderInterface
{
    private string $stacksPath;

    public function __construct(string $stacksPath)
    {
        $this->stacksPath = $stacksPath;
    }

    public function matches(Context $context): bool
    {
        return $context->withXdebug === true;
    }

    public function build(DTO\Stack $stack, Context $context): DTO\Stack
    {
        $stack->addServices(
            (new Service('dbgp'))
                ->setBuildContext('.docker/dbgp')
                ->addPorts(
                    new PortMapping(new Variable('DBGP_PORT'), 9001)
                )
                ->setRestartOnFailure(),
        );

        $stack->addFiles(
            new Resource\InMemory('.docker/dbgp/Dockerfile', <<<EOF
                FROM alpine

                MAINTAINER Grégory Planchat <gregory@kiboko.fr>

                RUN set -ex \
                    && apk add \
                        py-pip \
                    && pip2 install --upgrade pip \
                    && pip2 install komodo-python-dbgp

                CMD /usr/bin/pydbgpproxy -d 0.0.0.0:9000 -i 0.0.0.0:9001

                EXPOSE 9000 9001
                EOF),
        );

        $stack->addEnvironmentVariables(
            new EnvironmentVariable(new Variable('DBGP_PORT')),
            );

        return $stack;
    }
}