<?php

declare(strict_types=1);

namespace spec\Builder\Domain\Packaging\Context;

use Builder\Domain\Packaging;
use PhpSpec\ObjectBehavior;

final class BuildableContextSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(null, null, []);

        $this->shouldHaveType(Packaging\Context\BuildableContext::class);
        $this->shouldHaveType(Packaging\Context\ContextInterface::class);
        $this->shouldHaveType(Packaging\Context\BuildableContextInterface::class);
    }

    public function it_does_not_have_a_buildable_parent()
    {
        $this->beConstructedWith(new Packaging\Context\Context(null, []), '/path/to/dockerfile', []);

        $this->isParentBuildable()->shouldReturn(false);
    }

    public function it_does_fail_if_empty_path_and_not_a_buildable_parent()
    {
        $this->beConstructedWith(new Packaging\Context\Context(null, []), null, []);

        $this->shouldThrow(new \RuntimeException('Could not determine path from parent context.'))
            ->duringInstantiation();
    }

    public function it_does_have_a_buildable_parent()
    {
        $this->beConstructedWith(new Packaging\Context\BuildableContext(null, new Packaging\Placeholder('/path/to/dockerfile'), []), null, []);

        $this->isParentBuildable()->shouldReturn(true);
    }

    public function it_does_build_a_copy_from_parent()
    {
        $this->beConstructedWith(new Packaging\Context\BuildableContext(null, new Packaging\Placeholder('/path/to/dockerfile'), ['%lorem%' => 'ipsum']), null, []);

        $this->getParent(['%dolor%' => 'sit amet'])->shouldReturnAnInstanceOf(Packaging\Context\ContextInterface::class);
    }

    public function it_does_build_a_copy_from_parent_and_combine_variables()
    {
        $this->beConstructedWith(new Packaging\Context\BuildableContext(null, new Packaging\Placeholder('/path/to/dockerfile'), ['%lorem%' => 'ipsum']), null, []);

        $this->getParent(['%dolor%' => 'sit amet'])->shouldIterateAs(new \ArrayObject([
            '%lorem%' => 'ipsum',
            '%dolor%' => 'sit amet',
        ]));
    }

    public function it_does_build_a_copy_from_parent_and_replace_variables()
    {
        $this->beConstructedWith(new Packaging\Context\BuildableContext(null, new Packaging\Placeholder('/path/to/dockerfile'), ['%lorem%' => 'ipsum']), null, []);

        $this->getParent(['%lorem%' => 'ipsum sit amet'])->shouldIterateAs(new \ArrayObject([
            '%lorem%' => 'ipsum sit amet',
        ]));
    }

    public function it_does_copy_path_from_parent()
    {
        $this->beConstructedWith(new Packaging\Context\BuildableContext(null, new Packaging\Placeholder('/path/to/dockerfile'), ['%lorem%' => 'ipsum']), null, []);

        $this->getPath()->shouldBeLike('/path/to/dockerfile');
    }
}
