<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\OroPlatform\Service;

use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariable;
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
        return $context->isEnterpriseEdition === true;
    }

    private function buildImageTag(DTO\Context $context)
    {
        if (Semver::satisfies($context->applicationVersion, '^3.0')) {
            return 'docker.elastic.co/elasticsearch/elasticsearch-oss:6.8.7';
        }

        if (Semver::satisfies($context->applicationVersion, '^4.0')) {
            return 'docker.elastic.co/elasticsearch/elasticsearch-oss:7.6.1';
        }

        throw new \RuntimeException('No image satisfies the application version constraint.');
    }

    public function build(DTO\Stack $stack, DTO\Context $context): DTO\Stack
    {
        $stack->addServices(
            (new Service('elasticsearch', $this->buildImageTag($context)))
                ->addEnvironmentVariables(
                    new EnvironmentVariable(new Variable('cluster.name'), 'docker-cluster'),
                    new EnvironmentVariable(new Variable('bootstrap.memory_lock'), 'true'),
                    new EnvironmentVariable(new Variable('ES_JAVA_OPTS'), '-Xms512m -Xmx512m'),
                    new EnvironmentVariable(new Variable('discovery.type'), 'single-node'),
                    new EnvironmentVariable(new Variable('http.port'), '9200'),
                    new EnvironmentVariable(new Variable('http.cors.allow-origin'), 'http://localhost:${DEJAVU_PORT},http://127.0.0.1:${DEJAVU_PORT},http://192.168.64.4:${DEJAVU_PORT},http://dejavu:${DEJAVU_PORT},http://host.docker.internal:${DEJAVU_PORT}'),
                    new EnvironmentVariable(new Variable('http.cors.enabled'), 'true'),
                    new EnvironmentVariable(new Variable('http.cors.allow-headers'), 'X-Requested-With,X-Auth-Token,Content-Type,Content-Length,Authorization'),
                    new EnvironmentVariable(new Variable('http.cors.allow-credentials'), 'true'),
                )
                ->addPorts(
                    new PortMapping(new Variable('ELASTICSEARCH_PORT'), 9200)
                )
                ->addVolumeMappings(
                    new VolumeMapping('elasticsearch', '/usr/share/elasticsearch/data'),
                    new VolumeMapping('./.docker/elasticsearch/elasticsearch.yml', '/usr/share/elasticsearch/config/elasticsearch.yml'),
                )
                ->setRestartOnFailure(),
            (new Service('dejavu', 'appbaseio/dejavu'))
                ->addPorts(
                    new PortMapping(new Variable('DEJAVU_PORT'), 1358)
                )
            )
            ->addVolumes(
                new Volume('elasticsearch', ['driver' => 'local'])
            )
        ;

        $stack->addFiles(
            new Resource\InMemory('.docker/elasticsearch/elasticsearch.yml', <<<EOF
                http.host: 0.0.0.0

                # Uncomment the following lines for a production cluster deployment
                #transport.host: 0.0.0.0
                #discovery.zen.minimum_master_nodes: 1
                http.cors.enabled : true
                http.cors.allow-origin : "*"
                http.cors.allow-methods : OPTIONS, HEAD, GET, POST, PUT, DELETE
                http.cors.allow-headers : X-Requested-With,X-Auth-Token,Content-Type, Content-Length
                cluster.routing.allocation.disk.threshold_enabled: false
                EOF),
        );

        $stack->addEnvironmentVariables(
            new EnvironmentVariable(new Variable('ELASTICSEARCH_PORT')),
            new EnvironmentVariable(new Variable('DEJAVU_PORT')),
        );

        return $stack;
    }
}