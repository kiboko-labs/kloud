<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\OroPlatform\Service;

use Kiboko\Cloud\Domain\Stack\Compose\VolumeMapping;
use Kiboko\Cloud\Domain\Stack\DTO;
use Kiboko\Cloud\Domain\Stack\Resource;
use Kiboko\Cloud\Domain\Stack\ServiceBuilderInterface;
use Composer\Semver\Semver;

final class Logstash implements ServiceBuilderInterface
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
        if (Semver::satisfies($context->applicationVersion, '^3.0')) {
            return 'docker.elastic.co/logstash/logstash:6.8.11';
        }

        if (Semver::satisfies($context->applicationVersion, '^4.0')) {
            return 'docker.elastic.co/logstash/logstash:7.8.1';
        }

        throw new \RuntimeException('No image satisfies the application version constraint.');
    }

    public function build(DTO\Stack $stack, DTO\Context $context): DTO\Stack
    {
        $stack->addServices(
            (new Service('logstash', $this->buildImageTag($context)))
                ->addVolumeMappings(
                    new VolumeMapping('./.docker/logstash/logstash.yml', '/usr/share/logstash/config/logstash.yml'),
                    new VolumeMapping('./.docker/logstash/pipeline', '/usr/share/logstash/pipeline/'),
                )
                ->setRestartOnFailure()
                ->addDependencies('elasticsearch'),
            )
        ;

        $stack->addFiles(
            new Resource\InMemory('.docker/logstash/logstash.yml', <<<EOF
                pipeline:
                  batch:
                    delay: 50
                    size: 125
                EOF),
            new Resource\InMemory('.docker/logstash/pipeline/tcp.conf', <<<EOF
                input {
                  tcp {
                     port => 5044
                     host => "0.0.0.0"
                     codec => json
                  }
                }
                filter {
                  date {
                    match => [ "timeMillis", "UNIX_MS" ]
                  }
                }
                
                output {
                  elasticsearch {
                    hosts => "elasticsearch:9200"
                  }
                }
                EOF),
        );

        return $stack;
    }
}