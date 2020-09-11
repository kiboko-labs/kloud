<?php

namespace spec\Kiboko\Cloud\Domain\Stack\Compose;

use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;

class VariableSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('LOREM_IPSUM');

        $this->shouldHaveType(Variable::class);
    }

    function it_is_strigifiable()
    {
        $this->beConstructedWith('LOREM_IPSUM');
        $this->__toString()->shouldReturn('${LOREM_IPSUM}');
    }
}
