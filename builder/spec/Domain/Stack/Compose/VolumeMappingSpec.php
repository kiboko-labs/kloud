<?php

namespace spec\Builder\Domain\Stack\Compose;

use Builder\Domain\Stack\Compose\VolumeMapping;
use PhpSpec\ObjectBehavior;

class VolumeMappingSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('lorem', '/app');
        $this->shouldHaveType(VolumeMapping::class);
    }

    function it_has_named_volume()
    {
        $this->beConstructedWith('lorem', '/app');
        $this->__toString()->shouldReturn('lorem:/app');
    }

    function it_has_readonly_named_volume()
    {
        $this->beConstructedWith('lorem', '/app', true);
        $this->__toString()->shouldReturn('lorem:/app:ro');
    }

    function it_has_anonymous_volume()
    {
        $this->beConstructedWith('./', '/app');
        $this->__toString()->shouldReturn('./:/app');
    }

    function it_has_readonly_anonymous_volume()
    {
        $this->beConstructedWith('lorem', '/app', true);
        $this->__toString()->shouldReturn('lorem:/app:ro');
    }
}
