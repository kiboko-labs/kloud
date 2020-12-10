<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\OroPlatform\Service;

use Kiboko\Cloud\Domain\Stack\Compose\Service;
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
        if (in_array($context->application, ['oroplatform', 'orocrm']) && Semver::satisfies($context->applicationVersion, '^1.6 || ^2.0')
            || in_array($context->application, ['orocommerce']) && Semver::satisfies($context->applicationVersion, '^1.0')
            || in_array($context->application, ['marello']) && $context->isEnterpriseEdition && Semver::satisfies($context->applicationVersion, '^1.2')
            || in_array($context->application, ['marello']) && !$context->isEnterpriseEdition && Semver::satisfies($context->applicationVersion, '^1.4')
        ) {
            return 'docker.elastic.co/logstash/logstash:5.6.16';
        }

        if (in_array($context->application, ['oroplatform', 'orocrm', 'orocommerce']) && Semver::satisfies($context->applicationVersion, '^3.0')
            || in_array($context->application, ['marello']) && Semver::satisfies($context->applicationVersion, '^2.0')
        ) {
            return 'docker.elastic.co/logstash/logstash:6.8.11';
        }

        if (in_array($context->application, ['oroplatform', 'orocrm', 'orocommerce']) && Semver::satisfies($context->applicationVersion, '^4.0')
            || in_array($context->application, ['marello']) && Semver::satisfies($context->applicationVersion, '^3.0')
            || in_array($context->application, ['middleware']) && Semver::satisfies($context->applicationVersion, '^1.0')
        ) {
            return 'docker.elastic.co/logstash/logstash:7.8.1';
        }

        throw StackServiceNotApplicableException::noImageSatisfiesTheApplicationConstraint('logstash');
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
