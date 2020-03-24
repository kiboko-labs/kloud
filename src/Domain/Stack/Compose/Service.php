<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\Compose;

use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class Service implements NormalizableInterface
{
    private string $name;
    private ?string $image;
    private ?string $extendsService;
    private ?string $user;
    private ?string $group;
    /** @var PortMapping[] */
    private array $ports;
    /** @var EnvironmentVariableInterface[] */
    private array $environmentVariables;
    /** @var VolumeMapping[] */
    private array $volumes;
    private string $restartMode;
    private ?string $buildContext;
    private ?array $buildArguments;
    private array $dependencies;
    private array $command;

    public function __construct(string $name, ?string $image = null, array $command = [])
    {
        $this->name = $name;
        $this->image = $image;
        $this->extendsService = null;
        $this->user = null;
        $this->group = null;
        $this->ports = [];
        $this->environmentVariables = [];
        $this->volumes = [];
        $this->restartMode = 'no';
        $this->buildContext = null;
        $this->buildArguments = [];
        $this->dependencies = [];
        $this->command = $command;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getExtendedService(): ?string
    {
        return $this->extendsService;
    }

    public function getDependencies(): array
    {
        return $this->dependencies;
    }

    public function getBuildContext(): ?string
    {
        return $this->buildContext;
    }

    public function getPorts(): array
    {
        return $this->ports;
    }

    public function getEnvironmentVariables(): array
    {
        return $this->environmentVariables;
    }

    public function getVolumesMappings(): array
    {
        return $this->volumes;
    }

    public function getRestartMode(): string
    {
        return $this->restartMode;
    }

    public function extendsService(string $service): self
    {
        $this->extendsService = $service;

        return $this;
    }

    public function setUser(string $user, ?string $group): self
    {
        $this->user = $user;
        $this->group = $group;

        return $this;
    }

    public function setCommand(string ...$parts): self
    {
        $this->command = $parts;

        return $this;
    }

    public function setBuildContext(string $path): self
    {
        $this->buildContext = $path;

        return $this;
    }

    public function addBuildArguments(EnvironmentVariableInterface ...$arguments): self
    {
        array_push($this->buildArguments, ...$arguments);

        return $this;
    }

    public function addPorts(PortMapping ...$ports): self
    {
        array_push($this->ports, ...$ports);

        return $this;
    }

    public function addEnvironmentVariables(EnvironmentVariableInterface ...$environmentVariables): self
    {
        array_push($this->environmentVariables, ...$environmentVariables);

        return $this;
    }

    public function addVolumeMappings(VolumeMapping ...$volumes): self
    {
        array_push($this->volumes, ...$volumes);

        return $this;
    }

    public function setNoRestart(): self
    {
        $this->restartMode = 'no';

        return $this;
    }

    public function setRestartAlways(): self
    {
        $this->restartMode = 'always';

        return $this;
    }

    public function setRestartOnFailure(): self
    {
        $this->restartMode = 'on-failure';

        return $this;
    }

    public function addDependencies(string ...$service): self
    {
        array_push($this->dependencies, ...$service);

        return $this;
    }

    public function normalize(NormalizerInterface $normalizer, string $format = null, array $context = [])
    {
        if ($this->image === null && $this->buildContext === null && $this->extendsService === null) {
            throw new \RuntimeException('The service should have either an image, a build context declared or extend an existing service.');
        }

        $configuration = [];
        if ($this->image !== null) {
            $configuration['image'] = $this->image;
        }

        if ($this->buildContext !== null) {
            $configuration['build'] = [
                'context' => $this->buildContext,
            ];

            if (count($this->buildArguments) > 0) {
                $configuration['build']['args'] = iterator_to_array((function (iterable $variables): \Iterator {
                    /** @var EnvironmentVariableInterface $variable */
                    foreach ($variables as $variable) {
                        yield (string) $variable->getVariable()->name => $variable->getValue();
                    }
                })($this->buildArguments), true);
            }
        }

        if ($this->extendsService !== null) {
            $configuration['extends'] = [
                'service' => $this->extendsService,
            ];
        }

        if ($this->user !== null) {
            if ($this->group !== null) {
                $configuration['user'] = sprintf('%s:%s', $this->user, $this->group);
            } else {
                $configuration['user'] = $this->user;
            }
        }

        if (count($this->ports) > 0) {
            $configuration['ports'] = array_map(function (PortMapping $port) {
                return (string) $port;
            }, $this->ports);
        }

        if (count($this->environmentVariables) > 0) {
            $configuration['environment'] = iterator_to_array((function (iterable $variables): \Iterator {
                /** @var EnvironmentVariableInterface $variable */
                foreach ($variables as $variable) {
                    if ($variable instanceof InheritedEnvironmentVariable) {
                        yield sprintf('%s', (string) $variable->getVariable()->name);
                    } else {
                        yield sprintf('%s=%s', (string)$variable->getVariable()->name, $variable->getValue());
                    }
                }
            })($this->environmentVariables), true);
        }

        if (count($this->volumes) > 0) {
            $configuration['volumes'] = array_map(function (VolumeMapping $volume) {
                return (string) $volume;
            }, $this->volumes);
        }

        if (count($this->dependencies) > 0) {
            $configuration['depends_on'] = $this->dependencies;
        }

        if (count($this->command) > 0) {
            $configuration['command'] = $this->command;
        }

        return array_merge(
            $configuration,
            [
                'restart' => $this->restartMode,
            ],
        );
    }
}