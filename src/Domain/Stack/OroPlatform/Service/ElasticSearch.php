<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\OroPlatform\Service;

use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\Expression;
use Kiboko\Cloud\Domain\Stack\Compose\PortMapping;
use Kiboko\Cloud\Domain\Stack\Compose\Service;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use Kiboko\Cloud\Domain\Stack\Compose\Volume;
use Kiboko\Cloud\Domain\Stack\Compose\VolumeMapping;
use Kiboko\Cloud\Domain\Stack\DTO;
use Kiboko\Cloud\Domain\Stack\Resource;
use Kiboko\Cloud\Domain\Stack\ServiceBuilderInterface;
use Composer\Semver\Semver;

final class ElasticSearch implements ServiceBuilderInterface
{
    private string $stacksPath;

    public function __construct(string $stacksPath)
    {
        $this->stacksPath = $stacksPath;
    }

    public function matches(DTO\Context $context): bool
    {
        return $context->isEnterpriseEdition === true
            || $context->withElasticStack === true;
    }

    private function buildImageTag(DTO\Context $context)
    {
        if (in_array($context->application, ['oroplatform', 'orocrm', 'orocommerce']) && Semver::satisfies($context->applicationVersion, '^3.0')
            || in_array($context->application, ['marello']) && Semver::satisfies($context->applicationVersion, '^2.0')
        ) {
            return 'docker.elastic.co/elasticsearch/elasticsearch-oss:6.8.12';
        }

        if (in_array($context->application, ['oroplatform', 'orocrm', 'orocommerce']) && Semver::satisfies($context->applicationVersion, '^4.0')
            || in_array($context->application, ['marello']) && Semver::satisfies($context->applicationVersion, '^3.0')
            || in_array($context->application, ['middleware']) && Semver::satisfies($context->applicationVersion, '^1.0')
        ) {
            return 'docker.elastic.co/elasticsearch/elasticsearch-oss:7.9.1';
        }

        throw new \RuntimeException('No image satisfies the application version constraint.');
    }

    public function build(DTO\Stack $stack, DTO\Context $context): DTO\Stack
    {
        $stack->addServices(
            ($service = new Service('elasticsearch', $this->buildImageTag($context)))
                ->addEnvironmentVariables(
                    new EnvironmentVariable(new Variable('ES_JAVA_OPTS'), '-Xms512m -Xmx512m'),
                )
                ->addPorts(
                    new PortMapping(new Variable('ELASTICSEARCH_PORT'), 9200)
                )
                ->addVolumeMappings(
                    new VolumeMapping('elasticsearch', '/usr/share/elasticsearch/data'),
                    new VolumeMapping('./.docker/elasticsearch/elasticsearch.yml', '/usr/share/elasticsearch/config/elasticsearch.yml'),
                )
                ->setRestartOnFailure()
            )
            ->addVolumes(
                new Volume('elasticsearch', ['driver' => 'local'])
            )
        ;

        $stack->addFiles(
            new Resource\InMemory('.docker/elasticsearch/elasticsearch.yml', <<<EOF
                cluster.name: 'docker-cluster'
                bootstrap.memory_lock: true
                discovery.type: 'single-node'
                
                http.host: '0.0.0.0'
                http.port: 9200
                
                # Uncomment the following lines for a production cluster deployment
                #transport.host: 0.0.0.0
                #discovery.zen.minimum_master_nodes: 1
                
                http.cors.enabled : true
                http.cors.allow-headers: 'X-Requested-With,X-Auth-Token,Content-Type,Content-Length,Authorization'
                # Uncomment the following if you wish to open access to a 3rd-party application, like Dejavu.
                #http.cors.allow-origin: "http://localhost:1234,http://127.0.0.1:1234"
                http.cors.allow-credentials: true
                http.cors.allow-methods : 'OPTIONS, HEAD, GET, POST, PUT, DELETE'
                
                cluster.routing.allocation.disk.threshold_enabled: false
                EOF),
        );

        $stack->addEnvironmentVariables(
            new EnvironmentVariable(new Variable('ELASTICSEARCH_PORT')),
        );

        if ($context->withDejavu === true) {
            $stack->addServices(
                (new Service('dejavu', 'appbaseio/dejavu'))
                    ->addPorts(
                        new PortMapping(new Variable('DEJAVU_PORT'), 1358)
                    )
            );

            $stack->addEnvironmentVariables(
                new EnvironmentVariable(new Variable('DEJAVU_PORT')),
                );

            $service
                ->addEnvironmentVariables(
                    new EnvironmentVariable(new Variable('http.cors.allow-origin'), new Expression('http://', new Variable('APPLICATION_DOMAIN'), ':', new Variable('DEJAVU_PORT'))),
                );
        }

        return $stack;
    }
}