<?php

namespace spec\Builder\Package;

use Builder\BuildableContext;
use Builder\BuildableDependentTag;
use Builder\BuildableInterface;
use Builder\Command\BuildFrom;
use Builder\Command\CommandBusInterface;
use Builder\Package\BuildableEdition;
use Builder\Package\EditionInterface;
use Builder\Package\Repository;
use Builder\Package\Variation;
use Builder\Package\Version;
use Builder\Package\VersionInterface;
use Builder\PHP;
use Builder\TagReference;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BuildableEditionSpec extends ObjectBehavior
{
    function it_is_initializable(VersionInterface $version)
    {
        $this->beConstructedWith(new Repository('kiboko/php'), 'ee', '/path/to/dockerfile', $version);

        $this->shouldHaveType(BuildableEdition::class);
        $this->shouldHaveType(EditionInterface::class);
        $this->shouldHaveType(BuildableInterface::class);
    }

    function it_is_iterable()
    {
        $repository = new Repository('kiboko/php');
        $v31 = new Version('3.1',
            new Variation('postgres', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
            new Variation('mysql', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
        );
        $v41 = new Version('4.1',
            new Variation('postgres', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
            new Variation('mysql', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
        );

        $this->beConstructedWith($repository, 'ee', '/path/to/dockerfile/%package.edition%/', $v31, $v41);

        $this->shouldIterateBuildableTagsLike(new \ArrayIterator([
            new BuildableDependentTag($repository, new TagReference('7.4-fpm-postgres'), '/path/to/dockerfile/ee/', '7.4-fpm-ee-3.1-postgres'),
            new BuildableDependentTag($repository, new TagReference('7.4-cli-postgres'), '/path/to/dockerfile/ee/', '7.4-cli-ee-3.1-postgres'),
            new BuildableDependentTag($repository, new TagReference('7.4-fpm-mysql'), '/path/to/dockerfile/ee/', '7.4-fpm-ee-3.1-mysql'),
            new BuildableDependentTag($repository, new TagReference('7.4-cli-mysql'), '/path/to/dockerfile/ee/', '7.4-cli-ee-3.1-mysql'),
            new BuildableDependentTag($repository, new TagReference('7.4-fpm-postgres'), '/path/to/dockerfile/ee/', '7.4-fpm-ee-4.1-postgres'),
            new BuildableDependentTag($repository, new TagReference('7.4-cli-postgres'), '/path/to/dockerfile/ee/', '7.4-cli-ee-4.1-postgres'),
            new BuildableDependentTag($repository, new TagReference('7.4-fpm-mysql'), '/path/to/dockerfile/ee/', '7.4-fpm-ee-4.1-mysql'),
            new BuildableDependentTag($repository, new TagReference('7.4-cli-mysql'), '/path/to/dockerfile/ee/', '7.4-cli-ee-4.1-mysql'),
        ]));
    }

    function it_is_buildable(CommandBusInterface $commandBus)
    {
        $repository = new Repository('kiboko/php');
        $v31 = new Version('3.1',
            new Variation('postgres', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'))),
        );

        $this->beConstructedWith($repository, 'ee', '/path/to/dockerfile/%package.edition%/', $v31);

        $variables = new BuildableContext(
            null,
            '/path/to/dockerfile/ee/',
            [
                '%package.edition%' => 'ee',
                '%php.flavor%' => 'fpm',
                '%php.version%' => '7.4',
                '%package.variation%' => 'postgres',
                '%package.version%' => '3.1',
            ]
        );

        $commandBus->add(Argument::exact(new BuildFrom(
            $repository,
            new TagReference('%php.version%-%php.flavor%-%package.edition%-%package.version%-%package.variation%', $variables),
            new TagReference('%php.version%-%php.flavor%-%package.variation%', $variables),
            '/path/to/dockerfile/ee/'
        )))->shouldBeCalled();

        $this->build($commandBus);
    }
}
