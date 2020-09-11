<?php

namespace spec\Kiboko\Cloud\Domain\Stack\Compose;

use Kiboko\Cloud\Domain\Stack\Compose\PortMapping;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use PhpSpec\ObjectBehavior;

class PortMappingSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(1337);
        $this->shouldHaveType(PortMapping::class);
    }

    function it_maps_direct_port()
    {
        $this->beConstructedWith(1337);
        $this->__toString()->shouldReturn('1337');
    }

    function it_maps_direct_parametered_port()
    {
        $this->beConstructedWith(new Variable('LOREM_IPSUM'));
        $this->__toString()->shouldReturn('${LOREM_IPSUM}');
    }

    function it_maps_indirect_ports()
    {
        $this->beConstructedWith(1337, 1337);
        $this->__toString()->shouldReturn('1337:1337');
    }

    function it_maps_parametered_output_port()
    {
        $this->beConstructedWith(new Variable('LOREM_IPSUM'), 1337);
        $this->__toString()->shouldReturn('${LOREM_IPSUM}:1337');
    }

    function it_maps_parametered_input_port()
    {
        $this->beConstructedWith(1337, new Variable('LOREM_IPSUM'));
        $this->__toString()->shouldReturn('1337:${LOREM_IPSUM}');
    }

    function it_maps_parametered_both_ports()
    {
        $this->beConstructedWith(new Variable('LOREM_IPSUM'), new Variable('DOLOR_SIT_AMET'));
        $this->__toString()->shouldReturn('${LOREM_IPSUM}:${DOLOR_SIT_AMET}');
    }
}
