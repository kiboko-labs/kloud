<?php declare(strict_types=1);

namespace Builder\Domain\Stack\Compose\Normalizer;

use Builder\Domain\Stack\Compose;
use Builder\Domain\Stack\Compose\Service;
use Builder\Domain\Stack\Compose\Volume;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

final class StackDenormalizer implements DenormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === Compose\Stack::class;
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $stack = new Compose\Stack($data['version']);

        $stack->addServices(...(function (array $services) use ($format, $context) {
            foreach ($services as $name => $definition) {
                yield $this->serializer->denormalize($definition, Service::class, $format, $context + ['stack_service_name' => $name]);
            }
        })($data['services'] ?? []));

        $stack->addVolumes(...(function (array $volumes) {
            foreach ($volumes as $name => $definition) {
                yield new Volume($name, $definition);
            }
        })($data['volumes'] ?? []));

        return $stack;
    }
}