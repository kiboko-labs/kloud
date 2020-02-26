<?php

namespace spec\Builder\DependencyTree;

use Builder\DependencyTree\Node;
use Builder\DependencyTree\NodeInterface;
use Builder\DependencyTree\Processed;
use Builder\DependencyTree\ResolutionInterface;
use Builder\DependencyTree\Resolved;
use Builder\TagReference;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NodeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(new TagReference('7.4-fpm'));

        $this->shouldBeAnInstanceOf(Node::class);
        $this->shouldBeAnInstanceOf(NodeInterface::class);
    }

    public function it_can_have_dependencies()
    {
        $this->beConstructedWith(new TagReference('7.4-fpm-postgres'), new Node(new TagReference('7.4-fpm')));

        $this->shouldHaveCount(1);
    }

    public function it_can_add_dependencies()
    {
        $this->beConstructedWith(new TagReference('7.4-fpm'));

        $this->shouldHaveCount(0);

        $this->add(new Node(new TagReference('7.4-fpm')));

        $this->shouldHaveCount(1);
    }

    public function it_can_resolve(ResolutionInterface $resolved, ResolutionInterface $processed)
    {
        $this->beConstructedWith(
            new TagReference('7.4-fpm-orocommerce-ce-3.1-postgres'),
            new Node(
                new TagReference('7.4-fpm-postgres'),
                new Node(
                    new TagReference('7.4-fpm')
                )
            )
        );

        $resolved->push(Argument::exact(new Node(
            new TagReference('7.4-fpm')
        )))->shouldBeCalledOnce();
        $resolved->push(Argument::exact(new Node(
            new TagReference('7.4-fpm-postgres'),
            new Node(
                new TagReference('7.4-fpm')
            )
        )))->shouldBeCalledOnce();
        $resolved->push(Argument::exact(new Node(
            new TagReference('7.4-fpm-orocommerce-ce-3.1-postgres'),
            new Node(
                new TagReference('7.4-fpm-postgres'),
                new Node(
                    new TagReference('7.4-fpm')
                )
            )
        )))->shouldBeCalledOnce();

        $processed->push(Argument::exact(new Node(
            new TagReference('7.4-fpm')
        )))->shouldBeCalledOnce();
        $processed->push(Argument::exact(new Node(
            new TagReference('7.4-fpm-postgres'),
            new Node(
                new TagReference('7.4-fpm')
            )
        )))->shouldBeCalledOnce();
        $processed->push(Argument::exact(new Node(
            new TagReference('7.4-fpm-orocommerce-ce-3.1-postgres'),
            new Node(
                new TagReference('7.4-fpm-postgres'),
                new Node(
                    new TagReference('7.4-fpm')
                )
            )
        )))->shouldBeCalledOnce();

        $this->resolve($resolved, $processed);
    }

    public function it_can_cast_as_string()
    {
        $this->beConstructedWith(new TagReference('7.4-fpm'));

        $this->callOnWrappedObject('__toString')->shouldReturn('7.4-fpm');
    }
}
