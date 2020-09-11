<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\Compose;

use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class Expression implements \Stringable, NormalizableInterface, DenormalizableInterface
{
    private iterable $elements;

    /**
     * @param array<string|Variable> $elements
     */
    public function __construct(...$elements)
    {
        $this->elements = $elements;
    }

    public function __toString()
    {
        return implode('', array_map(function ($item) {
            return (string) $item;
        }, $this->elements));
    }

    public function normalize(NormalizerInterface $normalizer, string $format = null, array $context = [])
    {
        return (string) $this;
    }

    public function denormalize(DenormalizerInterface $denormalizer, $data, string $format = null, array $context = [])
    {
        // TODO: Implement denormalize() method.
    }
}