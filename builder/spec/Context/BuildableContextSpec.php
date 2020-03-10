<?php

declare(strict_types=1);

namespace spec\Builder\Context\Context;

use Builder\Context\BuildableContext;
use Builder\Context\BuildableContextInterface;
use Builder\Context\Context;
use Builder\Context\ContextInterface;
use PhpSpec\ObjectBehavior;

final class BuildableContextSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(null, null, []);

        $this->shouldHaveType(BuildableContext::class);
        $this->shouldHaveType(ContextInterface::class);
        $this->shouldHaveType(BuildableContextInterface::class);
    }

    public function it_does_not_have_a_buildable_parent()
    {
        $this->beConstructedWith(new Context(null, []), '/path/to/dockerfile', []);

        $this->isParentBuildable()->shouldReturn(false);
    }

    public function it_does_fail_if_empty_path_and_not_a_buildable_parent()
    {
        $this->beConstructedWith(new Context(null, []), null, []);

        $this->shouldThrow(new \RuntimeException('Could not determine path from parent context.'))
            ->duringInstantiation();
    }

    public function it_does_have_a_buildable_parent()
    {
        $this->beConstructedWith(new BuildableContext(null, '/path/to/dockerfile', []), null, []);

        $this->isParentBuildable()->shouldReturn(true);
    }

    public function it_does_build_a_copy_from_parent()
    {
        $this->beConstructedWith(new BuildableContext(null, '/path/to/dockerfile', ['%lorem%' => 'ipsum']), null, []);

        $this->fromParent(['%dolor%' => 'sit amet'])->shouldReturnAnInstanceOf(ContextInterface::class);
    }

    public function it_does_build_a_copy_from_parent_and_combine_variables()
    {
        $this->beConstructedWith(new BuildableContext(null, '/path/to/dockerfile', ['%lorem%' => 'ipsum']), null, []);

        $this->fromParent(['%dolor%' => 'sit amet'])->shouldIterateAs(new \ArrayObject([
            '%lorem%' => 'ipsum',
            '%dolor%' => 'sit amet',
        ]));
    }

    public function it_does_build_a_copy_from_parent_and_replace_variables()
    {
        $this->beConstructedWith(new BuildableContext(null, '/path/to/dockerfile', ['%lorem%' => 'ipsum']), null, []);

        $this->fromParent(['%lorem%' => 'ipsum sit amet'])->shouldIterateAs(new \ArrayObject([
            '%lorem%' => 'ipsum sit amet',
        ]));
    }

    public function it_does_copy_path_from_parent()
    {
        $this->beConstructedWith(new BuildableContext(null, '/path/to/dockerfile', ['%lorem%' => 'ipsum']), null, []);

        $this->getPath()->shouldBeLike('/path/to/dockerfile');
    }
}
