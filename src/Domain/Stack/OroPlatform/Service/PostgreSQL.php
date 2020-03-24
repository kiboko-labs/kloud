<?php declare(strict_types=1);

namespace Builder\Domain\Stack\OroPlatform\Service;

use Builder\Domain\Stack\Compose\EnvironmentVariable;
use Builder\Domain\Stack\Compose\PortMapping;
use Builder\Domain\Stack\Compose\Service;
use Builder\Domain\Stack\Compose\Variable;
use Builder\Domain\Stack\Compose\Volume;
use Builder\Domain\Stack\Compose\VolumeMapping;
use Builder\Domain\Stack\DTO;
use Builder\Domain\Stack\OroPlatform\FilesAwareTrait;
use Builder\Domain\Stack\ServiceBuilderInterface;

final class PostgreSQL implements ServiceBuilderInterface
{
    use FilesAwareTrait;

    public function __construct(string $stacksPath)
    {
        $this->stacksPath = $stacksPath;
    }

    public function matches(DTO\Context $context): bool
    {
        return $context->dbms === DTO\Context::DBMS_POSTGRESQL;
    }

    public function build(DTO\Stack $stack, DTO\Context $context): DTO\Stack
    {
        $stack->addServices(
            (new Service('sql', 'postgres:9.6-alpine'))
                ->addPorts(
                    new PortMapping(new Variable('SQL_PORT'), 5432),
                )
                ->addEnvironmentVariables(
                    new EnvironmentVariable(new Variable('POSTGRES_ROOT_PASSWORD'), 'password'),
                    new EnvironmentVariable(new Variable('POSTGRES_DB'), 'kiboko'),
                    new EnvironmentVariable(new Variable('POSTGRES_USER'), 'kiboko'),
                    new EnvironmentVariable(new Variable('POSTGRES_PASSWORD'), 'password'),
                )
                ->addVolumeMappings(
                    new VolumeMapping('./.docker/postgres@9.6/sql/uuid-ossp.sql', '/docker-entrypoint-initdb.d/00-uuid-ossp.sql', true),
                    new VolumeMapping('database', '/var/lib/postgresql/data'),
                )
                ->setRestartOnFailure()
            )
            ->addVolumes(
                new Volume('database', ['driver' => 'local'])
            )
        ;

        $stack->addFiles(
            $this->findFilesToCopy($context, '.docker/postgres@9.6/sql/uuid-ossp.sql')
        );

        $stack->addEnvironmentVariables(
            new EnvironmentVariable(new Variable('SQL_PORT')),
        );

        return $stack;
    }
}