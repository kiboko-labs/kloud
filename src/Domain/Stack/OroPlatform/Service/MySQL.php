<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\OroPlatform\Service;

use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\PortMapping;
use Kiboko\Cloud\Domain\Stack\Compose\Service;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use Kiboko\Cloud\Domain\Stack\Compose\Volume;
use Kiboko\Cloud\Domain\Stack\Compose\VolumeMapping;
use Kiboko\Cloud\Domain\Stack\DTO;
use Kiboko\Cloud\Domain\Stack\ServiceBuilderInterface;

final class MySQL implements ServiceBuilderInterface
{
    private string $stacksPath;

    public function __construct(string $stacksPath)
    {
        $this->stacksPath = $stacksPath;
    }

    public function matches(DTO\Context $context): bool
    {
        return $context->dbms === DTO\Context::DBMS_MYSQL;
    }

    public function build(DTO\Stack $stack, DTO\Context $context): DTO\Stack
    {
        $stack->addServices(
            (new Service('sql', 'mysql:5.7'))
                ->addPorts(
                    new PortMapping(new Variable('DATABASE_PORT'), 3306),
                )
                ->addEnvironmentVariables(
                    new EnvironmentVariable(new Variable('MYSQL_ROOT_PASSWORD'), new Variable('DATABASE_ROOT_PASSWORD')),
                    new EnvironmentVariable(new Variable('MYSQL_DATABASE'), new Variable('DATABASE_NAME')),
                    new EnvironmentVariable(new Variable('MYSQL_USER'), new Variable('DATABASE_USER')),
                    new EnvironmentVariable(new Variable('MYSQL_PASSWORD'), new Variable('DATABASE_PASSWORD')),
                )
                ->addVolumeMappings(
                    new VolumeMapping('database', '/var/lib/mysql'),
                )
                ->setRestartOnFailure()
                ->setHealthCheckShellCommand('mysqladmin ping --silent -u$${MYSQL_USER} -p$${MYSQL_PASSWORD}')
            )
            ->addVolumes(
                new Volume('database', ['driver' => 'local'])
            )
        ;

        $stack->addEnvironmentVariables(
            new EnvironmentVariable(new Variable('DATABASE_ROOT_PASSWORD'), 'password'),
            new EnvironmentVariable(new Variable('DATABASE_NAME')),
            new EnvironmentVariable(new Variable('DATABASE_USER')),
            new EnvironmentVariable(new Variable('DATABASE_PASSWORD'), 'password'),
            new EnvironmentVariable(new Variable('DATABASE_PORT')),
        );

        return $stack;
    }
}