<?php

namespace spec\Kiboko\Cloud\Domain\Packaging\DependencyTree;

use Kiboko\Cloud\Domain\Packaging\Context\BuildableContext;
use Kiboko\Cloud\Domain\Packaging\DependencyTree\Node;
use Kiboko\Cloud\Domain\Packaging\DependencyTree\NodeInterface;
use Kiboko\Cloud\Domain\Packaging\DependencyTree\ResolutionInterface;
use Kiboko\Cloud\Domain\Packaging\Native\PHP\Tag;
use Kiboko\Cloud\Domain\Packaging\Placeholder;
use Kiboko\Cloud\Domain\Packaging\Repository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NodeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(new Tag(new Repository('kiboko/php'), new BuildableContext(null, new Placeholder('/'), [])));

        $this->shouldBeAnInstanceOf(Node::class);
        $this->shouldBeAnInstanceOf(NodeInterface::class);
    }

    public function it_can_have_dependencies()
    {
        $this->beConstructedWith(
            new Tag(
                new Repository('kiboko/php'),
                new BuildableContext(
                    null,
                    new Placeholder('/'),
                    [
                        '%php.version%' => '7.4',
                        '%php.flavor%' => 'fpm-postgres',
                    ]
                )
            ),
            new Node(
                new Tag(
                    new Repository('kiboko/php'),
                    new BuildableContext(
                        null,
                        new Placeholder('/'),
                        [
                            '%php.version%' => '7.4',
                            '%php.flavor%' => 'fpm',
                        ]
                    )
                )
            )
        );

        $this->shouldHaveCount(1);
    }

    public function it_can_add_dependencies()
    {
        $this->beConstructedWith(
            new Tag(
                new Repository('kiboko/php'),
                new BuildableContext(
                    null,
                    new Placeholder('/'),
                    [
                        '%php.version%' => '7.4',
                        '%php.flavor%' => 'fpm-postgres',
                    ]
                )
            )
        );

        $this->shouldHaveCount(0);

        $this->add(
            new Node(
                new Tag(
                    new Repository('kiboko/php'),
                    new BuildableContext(
                        null,
                        new Placeholder('/'),
                        [
                            '%php.version%' => '7.4',
                            '%php.flavor%' => 'fpm-postgres',
                        ]
                    )
                )
            )
        );

        $this->shouldHaveCount(1);
    }

    public function it_can_resolve(ResolutionInterface $resolved, ResolutionInterface $processed)
    {
        $this->beConstructedWith(
            new Tag(
                new Repository('kiboko/php'),
                new BuildableContext(
                    null,
                    new Placeholder('/'),
                    [
                        '%php.version%' => '7.4',
                        '%php.flavor%' => 'fpm-blackfire',
                        '%package.name%' => 'orocommerce',
                        '%package.version%' => '3.1',
                        '%package.edition%' => 'ce',
                        '%package.variation%' => 'postgres',
                    ]
                )
            ),
            new Node(
                new Tag(
                    new Repository('kiboko/php'),
                    new BuildableContext(
                        null,
                        new Placeholder('/'),
                        [
                            '%php.version%' => '7.4',
                            '%php.flavor%' => 'fpm-blackfire',
                            '%package.variation%' => 'postgres',
                        ]
                    )
                ),
                new Node(
                    new Tag(
                        new Repository('kiboko/php'),
                        new BuildableContext(
                            null,
                            new Placeholder('/'),
                            [
                                '%php.version%' => '7.4',
                                '%php.flavor%' => 'fpm-blackfire',
                            ]
                        )
                    )
                )
            )
        );

        $root = new Node(
            new Tag(
                new Repository('kiboko/php'),
                new BuildableContext(
                    null,
                    new Placeholder('/'),
                    [
                        '%php.version%' => '7.4',
                        '%php.flavor%' => 'fpm-blackfire',
                    ]
                )
            )
        );

        $level1 = new Node(
            new Tag(
                new Repository('kiboko/php'),
                new BuildableContext(
                    null,
                    new Placeholder('/'),
                    [
                        '%php.version%' => '7.4',
                        '%php.flavor%' => 'fpm-blackfire',
                        '%package.variation%' => 'postgres',
                    ]
                )
            ),
            $root
        );

        $level2 = new Node(
            new Tag(
                new Repository('kiboko/php'),
                new BuildableContext(
                    null,
                    new Placeholder('/'),
                    [
                        '%php.version%' => '7.4',
                        '%php.flavor%' => 'fpm-blackfire',
                        '%package.name%' => 'orocommerce',
                        '%package.version%' => '3.1',
                        '%package.edition%' => 'ce',
                        '%package.variation%' => 'postgres',
                    ]
                )
            ),
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
        $this->beConstructedWith(new Tag(
            new Repository('kiboko/php'),
            new BuildableContext(
                null,
                new Placeholder('/'),
                [
                    '%php.version%' => '7.4',
                    '%php.flavor%' => 'fpm',
                ]
            )
        ));

        $this->callOnWrappedObject('__toString')->shouldReturn('7.4-fpm');
    }
}
