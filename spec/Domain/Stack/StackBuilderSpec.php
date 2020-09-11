<?php declare(strict_types=1);

namespace spec\Kiboko\Cloud\Domain\Stack;

use Kiboko\Cloud\Domain\Stack;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Yaml\Yaml;

final class StackBuilderSpec extends ObjectBehavior
{
    public function it_replaces_orocommerce_4_enterprise_services()
    {
        $config = Yaml::parse(file_get_contents(__DIR__ . '/data/orocommerce-ce-4.1/docker-compose.yml'));

        $serializer = new Serializer(
            [
                new Stack\Compose\Normalizer\StackDenormalizer(),
                new Stack\Compose\Normalizer\ServiceDenormalizer(),
                new CustomNormalizer(),
                new PropertyNormalizer(),
                new ObjectNormalizer(),
            ],
            [
                new YamlEncoder()
            ]
        );

        $stack = $serializer->denormalize(
            $config,
            Stack\Compose\Stack::class,
            'yaml',
            []
        );

        $this->beConstructedWith(new Stack\OroPlatform\Service\PHP('/path/to/stacks'));
    }
}