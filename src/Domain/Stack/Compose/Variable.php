<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\Compose;

use Kiboko\Cloud\Domain\Stack\StringableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class Variable implements \Stringable, NormalizableInterface, DenormalizableInterface
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return sprintf('${%s}', $this->name);
    }

    public function normalize(NormalizerInterface $normalizer, string $format = null, array $context = [])
    {
        return $this->name;
    }

    public function denormalize(DenormalizerInterface $denormalizer, $data, string $format = null, array $context = [])
    {
        $this->name = $data;
    }
}