<?php

namespace spec\Kiboko\Cloud\Domain\Stack\Compose;

use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\PortMapping;
use Kiboko\Cloud\Domain\Stack\Compose\Service;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use Kiboko\Cloud\Domain\Stack\Compose\VolumeMapping;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ServiceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('lorem');
        $this->shouldHaveType(Service::class);
    }

    function it_is_named()
    {
        $this->beConstructedWith('lorem');
        $this->getName()->shouldReturn('lorem');
    }

    function it_is_has_no_image()
    {
        $this->beConstructedWith('lorem');
        $this->getImage()->shouldReturn(null);
    }

    function it_is_has_an_image()
    {
        $this->beConstructedWith('lorem', 'kiboko/kloud');
        $this->getImage()->shouldReturn('kiboko/kloud');
    }

    function it_is_failing_normalization_without_an_image_or_a_build_context(NormalizerInterface $normalizer)
    {
        $this->beConstructedWith('lorem');

        $this->shouldThrow(new \RuntimeException('The service should have either an image, a build context declared or extend an existing service.'))
            ->during('normalize', [$normalizer]);
    }

    function it_is_normalizing_with_an_image(NormalizerInterface $normalizer)
    {
        $this->beConstructedWith('lorem', 'kiboko/php:kloud');

        $this->normalize($normalizer)
            ->shouldReturn([
                'image' => 'kiboko/php:kloud',
                'restart' => 'no',
            ]);
    }

    function it_is_normalizing_with_a_build_context(NormalizerInterface $normalizer)
    {
        $this->beConstructedWith('lorem');
        $this->setBuildContext('.docker/');

        $this->normalize($normalizer)
            ->shouldReturn([
                'build' => [
                    'context' => '.docker/',
                ],
                'restart' => 'no',
            ]);
    }

    function it_is_normalizing_with_a_build_context_and_arguments(NormalizerInterface $normalizer)
    {
        $this->beConstructedWith('lorem');
        $this->setBuildContext('.docker/');
        $this->addBuildArguments(new EnvironmentVariable(new Variable('LOREM_IPSUM'), 1234));

        $this->normalize($normalizer)
            ->shouldReturn([
                'build' => [
                    'context' => '.docker/',
                    'args' => [
                        'LOREM_IPSUM' => 1234,
                    ]
                ],
                'restart' => 'no',
            ]);
    }

    function it_is_normalizing_with_an_image_and_a_build_context(NormalizerInterface $normalizer)
    {
        $this->beConstructedWith('lorem', 'kiboko/php:kloud');
        $this->setBuildContext('.docker/');

        $this->normalize($normalizer)
            ->shouldReturn([
                'image' => 'kiboko/php:kloud',
                'build' => [
                    'context' => '.docker/',
                ],
                'restart' => 'no',
            ]);
    }

    function it_is_normalizing_with_port_mappings(NormalizerInterface $normalizer)
    {
        $this->beConstructedWith('lorem', 'kiboko/php:kloud');
        $this->addPorts(
            new PortMapping(1337),
            new PortMapping(1337, 1234),
            new PortMapping(1337, new Variable('LOREM_IPSUM')),
            new PortMapping(new Variable('LOREM_IPSUM'), 1337),
        );

        $this->normalize($normalizer)
            ->shouldReturn([
                'image' => 'kiboko/php:kloud',
                'ports' => [
                    '1337',
                    '1337:1234',
                    '1337:${LOREM_IPSUM}',
                    '${LOREM_IPSUM}:1337',
                ],
                'restart' => 'no',
            ]);
    }

    function it_is_normalizing_with_environemnt_variables(NormalizerInterface $normalizer)
    {
        $this->beConstructedWith('lorem', 'kiboko/php:kloud');
        $this->addEnvironmentVariables(
            new EnvironmentVariable(new Variable('LOREM_IPSUM'), 'lorem ipsum dolor sit amet'),
            new EnvironmentVariable(new Variable('DOLOR_SIT_AMET'), 'false'),
        );

        $this->normalize($normalizer)
            ->shouldReturn([
                'image' => 'kiboko/php:kloud',
                'environment' => [
                    'LOREM_IPSUM=lorem ipsum dolor sit amet',
                    'DOLOR_SIT_AMET=false',
                ],
                'restart' => 'no',
            ]);
    }

    function it_is_normalizing_with_volumes(NormalizerInterface $normalizer)
    {
        $this->beConstructedWith('lorem', 'kiboko/php:kloud');
        $this->addVolumeMappings(
            new VolumeMapping('./data', '/app/data'),
            new VolumeMapping('./.docker/bin', '/opt/docker/bin', true),
            new VolumeMapping('app', '/app', true),
            new VolumeMapping('cache', '/app/cache'),
        );

        $this->normalize($normalizer)
            ->shouldReturn([
                'image' => 'kiboko/php:kloud',
                'volumes' => [
                    './data:/app/data',
                    './.docker/bin:/opt/docker/bin:ro',
                    'app:/app:ro',
                    'cache:/app/cache',
                ],
                'restart' => 'no',
            ]);
    }

    function it_is_normalizing_with_no_restart(NormalizerInterface $normalizer)
    {
        $this->beConstructedWith('lorem', 'kiboko/php:kloud');
        $this->setNoRestart();

        $this->normalize($normalizer)
            ->shouldReturn([
                'image' => 'kiboko/php:kloud',
                'restart' => 'no',
            ]);
    }

    function it_is_normalizing_with_always_restart(NormalizerInterface $normalizer)
    {
        $this->beConstructedWith('lorem', 'kiboko/php:kloud');
        $this->setRestartAlways();

        $this->normalize($normalizer)
            ->shouldReturn([
                'image' => 'kiboko/php:kloud',
                'restart' => 'always',
            ]);
    }

    function it_is_normalizing_with_restart_on_failure(NormalizerInterface $normalizer)
    {
        $this->beConstructedWith('lorem', 'kiboko/php:kloud');
        $this->setRestartOnFailure();

        $this->normalize($normalizer)
            ->shouldReturn([
                'image' => 'kiboko/php:kloud',
                'restart' => 'on-failure',
            ]);
    }
}
