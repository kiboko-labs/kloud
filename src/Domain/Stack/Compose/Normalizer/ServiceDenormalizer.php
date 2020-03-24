<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\Compose\Normalizer;

use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\InheritedEnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\PortMapping;
use Kiboko\Cloud\Domain\Stack\Compose\Service;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use Kiboko\Cloud\Domain\Stack\Compose\VolumeMapping;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class ServiceDenormalizer implements DenormalizerInterface
{
    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === Service::class;
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $service = new Service($context['stack_service_name'], $data['image'] ?? null);

        if (isset($data['build']['context'])) {
            $service->setBuildContext($data['build']['context']);

            if (isset($data['build']['args'])) {
                foreach ($data['build']['args'] as $variable => $value) {
                    $service->addBuildArguments(new EnvironmentVariable(new Variable($variable), $value));
                }
            }
        }

        if (isset($data['extends']['service']) && !empty($data['extends']['service'])) {
            $service->extendsService($data['extends']['service']);
        }

        if (isset($data['user']) && preg_match('/^([^:]+):([^:]+)$/', $data['user'], $matches)) {
            $service->setUser($matches[1], $matches[2] ?: null);
        }

        $service->addPorts(...array_map(function(string $ports) {
            if (!preg_match('/^(?:(\d+)|\$\{([a-zA-Z0-9_]+)\}):(?:(\d+)|\$\{([a-zA-Z0-9_]+)\})$/', $ports, $matches)) {
                throw new \InvalidArgumentException('The port mapping specification is invalid.');
            }

            if (!empty($matches[1])) {
                $out = (int) $matches[1];
            } else if (!empty($matches[2])) {
                $out = new Variable($matches[2]);
            } else {
                throw new \RuntimeException('Cound not match any output port.');
            }

            if (!empty($matches[3])) {
                $in = (int) $matches[3];
            } else if (!empty($matches[4])) {
                $in = new Variable($matches[4]);
            } else {
                throw new \RuntimeException('Cound not match any input port.');
            }

            return new PortMapping($out, $in);
        }, $data['ports'] ?? []));

        if (isset($data['environment'])) {
            foreach ($data['environment'] as $variable => $value) {
                if (is_int($variable)) {
                    if (!preg_match('/^(?:([^=]+)=(.*)|(.*))$/', $value, $matches)) {
                        throw new \RuntimeException(strtr('Invalid environment variable format: "%value%".', ['%value%' => $value]));
                    }

                    if (isset($matches[1]) && !empty($matches[1])) {
                        $service->addEnvironmentVariables(new EnvironmentVariable(new Variable($matches[1]), $matches[2]));
                    } else {
                        $service->addEnvironmentVariables(new InheritedEnvironmentVariable(new Variable($matches[3])));
                    }
                } else if (!empty($value)) {
                    $service->addEnvironmentVariables(new EnvironmentVariable(new Variable($variable), $value));
                } else {
                    $service->addEnvironmentVariables(new InheritedEnvironmentVariable(new Variable($variable)));
                }
            }
        }

        if (isset($data['volumes'])) {
            foreach ($data['volumes'] as $volume) {
                if (!preg_match('/^(?:([^:]+):(.*)|([^:]+):([^:]+):(\w{2,}))$/', $volume, $matches)) {
                    throw new \RuntimeException(strtr('Invalid volume mapping format: "%volume%".', ['%volume%' => $volume]));
                }

                if (isset($matches[1]) && !empty($matches[1])) {
                    $service->addVolumeMappings(new VolumeMapping($matches[1], $matches[2]));
                } else if (isset($matches[3]) && !empty($matches[3])) {
                    $service->addVolumeMappings(new VolumeMapping($matches[3], $matches[4], $matches[5] === 'ro'));
                }
            }
        }

        if (isset($data['depends_on']) && !empty($data['depends_on'])) {
            $service->addDependencies(...$data['depends_on']);
        }

        if (isset($data['command']) && !empty($data['command'])) {
            $service->setCommand(...$data['command']);
        }

        if (isset($data['restart'])) {
            if ($data['restart'] === 'on-failure') {
                $service->setRestartOnFailure();
            } else if ($data['restart'] === 'always') {
                $service->setRestartAlways();
            } else if ($data['restart'] === 'no') {
                $service->setNoRestart();
            }
        }

        return $service;
    }
}