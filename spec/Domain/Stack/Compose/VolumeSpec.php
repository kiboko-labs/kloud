<?php

namespace spec\Kiboko\Cloud\Domain\Stack\Compose;

use Kiboko\Cloud\Domain\Stack\Compose\Volume;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class VolumeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('lorem', []);

        $this->shouldHaveType(Volume::class);
        $this->shouldHaveType(NormalizableInterface::class);
        $this->shouldHaveType(DenormalizableInterface::class);
    }

    function it_is_named()
    {
        $this->beConstructedWith('lorem', []);

        $this->getName()->shouldReturn('lorem');
    }

    function it_is_configured()
    {
        $this->beConstructedWith('lorem', ['foo' => ['bar', 'baz']]);

        $this->getConfig()->shouldReturn(['foo' => ['bar', 'baz']]);
    }

    function it_is_normalizable(NormalizerInterface $normalizer)
    {
        $this->beConstructedWith('lorem', ['foo' => ['bar', 'baz']]);

        $this->normalize($normalizer)->shouldReturn(['foo' => ['bar', 'baz']]);
    }
}
