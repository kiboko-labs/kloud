<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\OroPlatform\Service;

use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\PortMapping;
use Kiboko\Cloud\Domain\Stack\Compose\Service;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use Kiboko\Cloud\Domain\Stack\Compose\VolumeMapping;
use Kiboko\Cloud\Domain\Stack\DTO;
use Kiboko\Cloud\Domain\Stack\Resource;
use Kiboko\Cloud\Domain\Stack\ServiceBuilderInterface;
use Composer\Semver\Semver;

final class Kibana implements ServiceBuilderInterface
{
    private string $stacksPath;

    public function __construct(string $stacksPath)
    {
        $this->stacksPath = $stacksPath;
    }

    public function matches(DTO\Context $context): bool
    {
        return $context->withElasticStack === true;
    }

    private function buildImageTag(DTO\Context $context)
    {
        if (in_array($context->application, ['oroplatform', 'orocrm']) && Semver::satisfies($context->applicationVersion, '^1.6 || ^2.0')
            || in_array($context->application, ['orocommerce']) && Semver::satisfies($context->applicationVersion, '^1.0')
            || in_array($context->application, ['marello']) && $context->isEnterpriseEdition && Semver::satisfies($context->applicationVersion, '^1.2')
            || in_array($context->application, ['marello']) && !$context->isEnterpriseEdition && Semver::satisfies($context->applicationVersion, '^1.4')
        ) {
            return 'docker pull docker.elastic.co/kibana/kibana:5.6.16';
        }

        if (in_array($context->application, ['oroplatform', 'orocrm', 'orocommerce']) && Semver::satisfies($context->applicationVersion, '^3.0')
            || in_array($context->application, ['marello']) && Semver::satisfies($context->applicationVersion, '^2.0')
        ) {
            return 'docker.elastic.co/kibana/kibana:6.8.11';
        }

        if (in_array($context->application, ['oroplatform', 'orocrm', 'orocommerce']) && Semver::satisfies($context->applicationVersion, '^4.0')
            || in_array($context->application, ['marello']) && Semver::satisfies($context->applicationVersion, '^3.0')
            || in_array($context->application, ['middleware']) && Semver::satisfies($context->applicationVersion, '^1.0')
        ) {
            return 'docker.elastic.co/kibana/kibana:7.8.1';
        }

        if (in_array($context->application, ['oroplatform', 'orocrm', 'orocommerce']) && Semver::satisfies($context->applicationVersion, '^5.0')
        ) {
            return 'docker.elastic.co/kibana/kibana:7.16.1';
        }

        throw StackServiceNotApplicableException::noImageSatisfiesTheApplicationConstraint('kibana');
    }

    public function build(DTO\Stack $stack, DTO\Context $context): DTO\Stack
    {
        $stack->addServices(
            (new Service('kibana', $this->buildImageTag($context)))
                ->addEnvironmentVariables(
                    new EnvironmentVariable(new Variable('monitoring.elasticsearch.hosts'), 'http://elasticsearch:9200'),
                )
                ->addPorts(
                    new PortMapping(new Variable('KIBANA_PORT'), 5601)
                )
                ->addVolumeMappings(
                    new VolumeMapping('./.docker/kibana/kibana.yml', '/usr/share/kibana/config/kibana.yml'),
                )
                ->setRestartOnFailure()
                ->addDependencies('elasticsearch'),
            )
        ;

        $stack->addFiles(
            new Resource\InMemory('.docker/kibana/kibana.yml', <<<EOF
                server.port: 5601
                server.host: "0.0.0.0"
                elasticsearch.hosts: "http://elasticsearch:9200"
                EOF),
        );

        $stack->addEnvironmentVariables(
            new EnvironmentVariable(new Variable('KIBANA_PORT')),
        );

        return $stack;
    }
}
