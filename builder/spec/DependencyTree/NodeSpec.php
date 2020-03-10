<?php

namespace spec\Builder\DependencyTree;

use Builder\DependencyTree\Node;
use Builder\DependencyTree\NodeInterface;
use Builder\DependencyTree\ResolutionInterface;
use Builder\Package\Repository;
use Builder\Tag\BuildableTag;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NodeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(new BuildableTag(new Repository('kiboko/php'), '/', '7.4-fpm'));

        $this->shouldBeAnInstanceOf(Node::class);
        $this->shouldBeAnInstanceOf(NodeInterface::class);
    }

    public function it_can_have_dependencies()
    {
        $this->beConstructedWith(new BuildableTag(new Repository('kiboko/php'), '/', '7.4-fpm-postgres'), new Node(new BuildableTag(new Repository('kiboko/php'), '/', '7.4-fpm')));

        $this->shouldHaveCount(1);
    }

    public function it_can_add_dependencies()
    {
        $this->beConstructedWith(new BuildableTag(new Repository('kiboko/php'), '/', '7.4-fpm-postgres'));

        $this->shouldHaveCount(0);

        $this->add(new Node(new BuildableTag(new Repository('kiboko/php'), '/', '7.4-fpm')));

        $this->shouldHaveCount(1);
    }

    public function it_can_resolve(ResolutionInterface $resolved, ResolutionInterface $processed)
    {
        $this->beConstructedWith(
            new BuildableTag(new Repository('kiboko/php'), '/', '7.4-fpm-orocommerce-ce-3.1-postgres'),
            new Node(
                new BuildableTag(new Repository('kiboko/php'), '/', '7.4-fpm-postgres'),
                new Node(
                    new BuildableTag(new Repository('kiboko/php'), '/', '7.4-fpm')
                )
            )
        );

        $root = new Node(
            new BuildableTag(new Repository('kiboko/php'), '/', '7.4-fpm')
        );

        $level1 = new Node(
            new BuildableTag(new Repository('kiboko/php'), '/', '7.4-fpm-postgres'),
            $root
        );

        $level2 = new Node(
            new BuildableTag(new Repository('kiboko/php'), '/', '7.4-fpm-orocommerce-ce-3.1-postgres'),
            $level1
        );

        $resolved->push(Argument::exact($root))->shouldBeCalledOnce();
        $resolved->push(Argument::exact($level1))->shouldBeCalledOnce();
        $resolved->push(Argument::exact($level2))->shouldBeCalledOnce();

        $processed->push(Argument::exact($root))->shouldBeCalledOnce();
        $processed->push(Argument::exact($level1))->shouldBeCalledOnce();
        $processed->push(Argument::exact($level2))->shouldBeCalledOnce();

        $this->resolve($resolved, $processed);
    }

    public function it_can_cast_as_string()
    {
        $this->beConstructedWith(new BuildableTag(new Repository('kiboko/php'), '/', '7.4-fpm'));

        $this->callOnWrappedObject('__toString')->shouldReturn('7.4-fpm');
    }
}
