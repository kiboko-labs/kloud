<?php

declare(strict_types=1);

namespace spec\Kiboko\Cloud\Domain\Packaging\Context;

use Kiboko\Cloud\Domain\Packaging;
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
        $this->beConstructedWith(
            new Packaging\Context\Context(null, []),
            new Packaging\Placeholder('/path/to/dockerfile'),
            []
        );

        $this->asBuildable()->shouldReturnAnInstanceOf(Packaging\Context\BuildableContextInterface::class);
    }

    public function it_does_fail_if_empty_path()
    {
        $this->beConstructedWith(null, null, []);

        $this->shouldThrow(new \RuntimeException('Could not determine path from parent context, please provide a path for the context.'))
            ->duringInstantiation();
    }

    public function it_does_fail_if_empty_path_and_not_a_buildable_parent()
    {
        $this->beConstructedWith(new Packaging\Context\Context(null, []), null, []);

        $this->shouldThrow(new \RuntimeException('Could not determine path from parent context, please provide a path for the context.'))
            ->duringInstantiation();
    }

    public function it_does_have_a_buildable_parent()
    {
        $this->beConstructedWith(new Packaging\Context\BuildableContext(null, new Packaging\Placeholder('/path/to/dockerfile'), []), null, []);

        $this->asBuildable()->shouldReturnAnInstanceOf(Packaging\Context\BuildableContextInterface::class);
    }

    public function it_does_build_a_copy_from_parent()
    {
        $this->beConstructedWith(new Packaging\Context\BuildableContext(null, new Packaging\Placeholder('/path/to/dockerfile'), ['%lorem%' => 'ipsum']), null, []);

        $this->getParent()->shouldReturnAnInstanceOf(Packaging\Context\ContextInterface::class);
    }

    public function it_does_build_a_copy_from_parent_and_combine_variables()
    {
        $this->beConstructedWith(new Packaging\Context\BuildableContext(null, new Packaging\Placeholder('/path/to/dockerfile'), ['%lorem%' => 'ipsum']), null, []);

        $this->getBuildableParent(null, ['%dolor%' => 'sit amet'])->shouldIterateAs(new \ArrayObject([
            '%dolor%' => 'sit amet',
            '%lorem%' => 'ipsum',
        ]));
    }

    public function it_does_build_a_copy_from_parent_and_replace_variables()
    {
        $this->beConstructedWith(new Packaging\Context\BuildableContext(null, new Packaging\Placeholder('/path/to/dockerfile'), ['%lorem%' => 'ipsum']), null, []);

        $this->getBuildableParent(null, ['%lorem%' => 'ipsum sit amet'])->shouldIterateAs(new \ArrayObject([
            '%lorem%' => 'ipsum sit amet',
        ]));
    }

    public function it_does_copy_path_from_parent()
    {
        $this->beConstructedWith(new Packaging\Context\BuildableContext(null, new Packaging\Placeholder('/path/to/dockerfile'), ['%lorem%' => 'ipsum']), null, []);

        $this->getPath()->shouldBeLike('/path/to/dockerfile');
    }
}
