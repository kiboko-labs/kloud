<?php declare(strict_types=1);

namespace spec\Kiboko\Cloud\Domain\Stack\Compose;

use Kiboko\Cloud\Domain\Stack\Compose\Expression;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use PhpSpec\ObjectBehavior;

class ExpressionParserSpec extends ObjectBehavior
{
    function it_parses_a_string()
    {
        $this->parse('LOREM_IPSUM')
            ->shouldBeLike(new Expression('LOREM_IPSUM'));
    }

    function it_parses_a_simple_variable()
    {
        $this->parse('$LOREM_IPSUM')
            ->shouldBeLike(new Expression(new Variable('LOREM_IPSUM')));
    }

    function it_parses_a_simple_variable_with_prefix()
    {
        $this->parse('test:$LOREM_IPSUM')
            ->shouldBeLike(new Expression('test:', new Variable('LOREM_IPSUM')));
    }

    function it_parses_a_simple_variable_with_suffix()
    {
        $this->parse('$LOREM_IPSUM:test')
            ->shouldBeLike(new Expression(new Variable('LOREM_IPSUM'), ':test'));
    }

    function it_parses_a_complex_variable()
    {
        $this->parse('${LOREM_IPSUM}')
            ->shouldBeLike(new Expression(new Variable('LOREM_IPSUM')));
    }

    function it_parses_a_complex_variable_with_prefix()
    {
        $this->parse('test-${LOREM_IPSUM}')
            ->shouldBeLike(new Expression('test-', new Variable('LOREM_IPSUM')));
    }

    function it_parses_a_complex_variable_with_suffix()
    {
        $this->parse('${LOREM_IPSUM}-test')
            ->shouldBeLike(new Expression(new Variable('LOREM_IPSUM'), '-test'));
    }

    function it_parses_two_complex_variables()
    {
        $this->parse('${LOREM_IPSUM}:${DOLOR}')
            ->shouldBeLike(new Expression(new Variable('LOREM_IPSUM'), ':', new Variable('DOLOR')));
    }
}