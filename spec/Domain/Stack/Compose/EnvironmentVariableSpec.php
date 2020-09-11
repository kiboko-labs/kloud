<?php

namespace spec\Kiboko\Cloud\Domain\Stack\Compose;

use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use PhpSpec\ObjectBehavior;

class EnvironmentVariableSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(new Variable('LOREM_IPSUM'));
        $this->shouldHaveType(EnvironmentVariable::class);
    }

    function it_is_stringifiable()
    {
        $this->beConstructedWith(new Variable('LOREM_IPSUM'));

        $this->__toString()->shouldReturn('LOREM_IPSUM');
    }

    function it_contains_a_variable()
    {
        $this->beConstructedWith(new Variable('LOREM_IPSUM'));

        $this->getVariable()->shouldReturnAnInstanceOf(Variable::class);
    }

    function it_contains_a_value()
    {
        $this->beConstructedWith(new Variable('LOREM_IPSUM'), 'lorem ipsum dolor sit amet');

        $this->getValue()->shouldReturn('lorem ipsum dolor sit amet');
    }
}
