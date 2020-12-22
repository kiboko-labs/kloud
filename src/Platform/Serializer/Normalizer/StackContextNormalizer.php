<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Serializer\Normalizer;

use Kiboko\Cloud\Domain\Packaging\Repository;
use Kiboko\Cloud\Domain\Stack\DTO\Context;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class StackContextNormalizer implements DenormalizerInterface
{
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return new Context(
            new Repository($data['repository']['name']),
            $data['phpVersion'],
            $data['application'] ?? null,
            $data['applicationVersion'] ?? null,
            $data['dbms'] ?? null,
            $data['isEnterpriseEdition'] ?? null,
        );
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === Context::class && $format === 'yaml';
    }
}