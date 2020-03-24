<?php declare(strict_types=1);

namespace Builder\Domain\Stack\Compose;

use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class Volume implements NormalizableInterface, DenormalizableInterface
{
    private string $name;
    private array $config;

    public function __construct(string $name, array $config)
    {
        $this->name = $name;
        $this->config = $config;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function normalize(NormalizerInterface $normalizer, string $format = null, array $context = [])
    {
        return $this->config;
    }

    public function denormalize(DenormalizerInterface $denormalizer, $data, string $format = null, array $context = [])
    {
        $this->config = $data;

        return $this;
    }
}