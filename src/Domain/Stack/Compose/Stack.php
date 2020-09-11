<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\Compose;

use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class Stack implements NormalizableInterface
{
    private ?string $version;
    /** @var Service[] */
    private array $services;
    /** @var Volume[] */
    private array $volumes;

    public function __construct(?string $version = null)
    {
        $this->version = $version;
        $this->services = [];
        $this->volumes = [];
    }

    public function addServices(Service ...$services): self
    {
        array_push($this->services, ...$services);

        return $this;
    }

    public function removeServices(Service ...$services): self
    {
        $this->services = array_filter($this->services, function (Service $service) use ($services) {
            return !in_array($service, $services, true);
        });

        return $this;
    }

    public function replaceServices(Service ...$services): self
    {
        foreach ($services as $service) {
            $this->replaceService($service);
        }

        return $this;
    }

    private function replaceService(Service $replacement): void
    {
        foreach ($this->services as &$service) {
            if ($service->getName() === $replacement->getName()) {
                $service = $replacement;
            }
        }
    }

    public function getServices(): array
    {
        return $this->services;
    }

    /**
     * @return array|Service[]
     */
    public function extractServices(string ...$names): array
    {
        $list = array_filter($this->services, function (Service $service) use ($names) {
            return in_array($service->getName(), $names, true);
        });

        usort($list, function(Service $left, Service $right) use ($names) {
            return (array_search($left->getName(), $names, true) <=> array_search($right->getName(), $names, true));
        });

        return $list;
    }

    public function addVolumes(Volume ...$volumes): self
    {
        array_push($this->volumes, ...$volumes);

        return $this;
    }

    public function removeVolumes(Volume ...$volumes): self
    {
        $this->volumes = array_filter($this->volumes, function (Volume $volume) use ($volumes) {
            return !in_array($volume, $volumes, true);
        });

        return $this;
    }

    public function replaceVolumes(Volume ...$volumes): self
    {
        foreach ($volumes as $volume) {
            $this->replaceVolume($volume);
        }

        return $this;
    }

    private function replaceVolume(Volume $replacement): void
    {
        foreach ($this->volumes as &$volume) {
            if ($volume->getName() === $replacement->getName()) {
                $volume = $replacement;
            }
        }
    }

    public function getVolumes(): array
    {
        return $this->volumes;
    }

    /**
     * @return array|Volume[]
     */
    public function extractVolumes(string ...$names): array
    {
        $list = array_filter($this->volumes, function (Volume $volume) use ($names) {
            return in_array($volume->getName(), $names, true);
        });

        usort($list, function(Volume $left, Volume $right) use ($names) {
            return (array_search($left->getName(), $names, true) <=> array_search($right->getName(), $names, true));
        });

        return $list;
    }

    public function normalize(NormalizerInterface $normalizer, string $format = null, array $context = [])
    {
        return [
            'version' => $this->version,
            'services' => iterator_to_array((function (Service ...$services) use ($normalizer, $format, $context) {
                foreach ($services as $service) {
                    yield $service->getName() => $normalizer->normalize($service, $format, $context);
                }
            })(...$this->services), true),
            'volumes' => iterator_to_array((function (Volume ...$volumes) use ($normalizer, $format, $context) {
                foreach ($volumes as $volume) {
                    yield $volume->getName() => $normalizer->normalize($volume, $format, $context);
                }
            })(...$this->volumes), true),
        ];
    }
}