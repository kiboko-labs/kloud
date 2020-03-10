<?php

namespace spec\Builder\Package;

use Builder\BuildableInterface;
use Builder\Command\BuildFrom;
use Builder\Command\CommandBusInterface;
use Builder\Context\BuildableContext;
use Builder\Context\Context;
use Builder\Package\BuildableDependentPackage;
use Builder\Package\BuildableEdition;
use Builder\Package\BuildablePackageInterface;
use Builder\Package\DependentPackageInterface;
use Builder\Package\Edition;
use Builder\Package\EditionInterface;
use Builder\Package\Repository;
use Builder\Package\Variation;
use Builder\Package\Version;
use Builder\PHP;
use Builder\Tag\BuildableDependentTag;
use Builder\Tag\TagReference;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BuildableDependentPackageSpec extends ObjectBehavior
{
    public function it_is_initializable(EditionInterface $edition)
    {
        $this->beConstructedWith(new Repository('kiboko/php'), 'commerce', 'platform', '/path/to/dockerfile', $edition);

        $this->shouldHaveType(BuildableDependentPackage::class);
        $this->shouldHaveType(DependentPackageInterface::class);
        $this->shouldHaveType(BuildableInterface::class);
        $this->shouldHaveType(BuildablePackageInterface::class);
    }

    public function it_is_iterable()
    {
        $repository = new Repository('kiboko/php');
        $ce = new Edition('ce',
            new Version('3.1',
                new Variation('postgres', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
                new Variation('mysql', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
            ), new Version('4.1',
                new Variation('postgres', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
                new Variation('mysql', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
            ),
        );
        $ee = new Edition('ee',
            new Version('3.1',
                new Variation('postgres', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
                new Variation('mysql', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
            ), new Version('4.1',
                new Variation('postgres', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
                new Variation('mysql', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
            ),
        );

        $this->beConstructedWith($repository, 'commerce', 'platform', '/path/to/dockerfile/%package.name%/%package.edition%/', $ce, $ee);

        $this->shouldIterateBuildableTagsLike(new \ArrayIterator([
            new BuildableDependentTag($repository, new TagReference('7.4-fpm-platform-ce-3.1-postgres'), '/path/to/dockerfile/commerce/ce/', '7.4-fpm-commerce-ce-3.1-postgres'),
            new BuildableDependentTag($repository, new TagReference('7.4-cli-platform-ce-3.1-postgres'), '/path/to/dockerfile/commerce/ce/', '7.4-cli-commerce-ce-3.1-postgres'),
            new BuildableDependentTag($repository, new TagReference('7.4-fpm-platform-ce-3.1-mysql'), '/path/to/dockerfile/commerce/ce/', '7.4-fpm-commerce-ce-3.1-mysql'),
            new BuildableDependentTag($repository, new TagReference('7.4-cli-platform-ce-3.1-mysql'), '/path/to/dockerfile/commerce/ce/', '7.4-cli-commerce-ce-3.1-mysql'),
            new BuildableDependentTag($repository, new TagReference('7.4-fpm-platform-ce-4.1-postgres'), '/path/to/dockerfile/commerce/ce/', '7.4-fpm-commerce-ce-4.1-postgres'),
            new BuildableDependentTag($repository, new TagReference('7.4-cli-platform-ce-4.1-postgres'), '/path/to/dockerfile/commerce/ce/', '7.4-cli-commerce-ce-4.1-postgres'),
            new BuildableDependentTag($repository, new TagReference('7.4-fpm-platform-ce-4.1-mysql'), '/path/to/dockerfile/commerce/ce/', '7.4-fpm-commerce-ce-4.1-mysql'),
            new BuildableDependentTag($repository, new TagReference('7.4-cli-platform-ce-4.1-mysql'), '/path/to/dockerfile/commerce/ce/', '7.4-cli-commerce-ce-4.1-mysql'),
            new BuildableDependentTag($repository, new TagReference('7.4-fpm-platform-ee-3.1-postgres'), '/path/to/dockerfile/commerce/ee/', '7.4-fpm-commerce-ee-3.1-postgres'),
            new BuildableDependentTag($repository, new TagReference('7.4-cli-platform-ee-3.1-postgres'), '/path/to/dockerfile/commerce/ee/', '7.4-cli-commerce-ee-3.1-postgres'),
            new BuildableDependentTag($repository, new TagReference('7.4-fpm-platform-ee-3.1-mysql'), '/path/to/dockerfile/commerce/ee/', '7.4-fpm-commerce-ee-3.1-mysql'),
            new BuildableDependentTag($repository, new TagReference('7.4-cli-platform-ee-3.1-mysql'), '/path/to/dockerfile/commerce/ee/', '7.4-cli-commerce-ee-3.1-mysql'),
            new BuildableDependentTag($repository, new TagReference('7.4-fpm-platform-ee-4.1-postgres'), '/path/to/dockerfile/commerce/ee/', '7.4-fpm-commerce-ee-4.1-postgres'),
            new BuildableDependentTag($repository, new TagReference('7.4-cli-platform-ee-4.1-postgres'), '/path/to/dockerfile/commerce/ee/', '7.4-cli-commerce-ee-4.1-postgres'),
            new BuildableDependentTag($repository, new TagReference('7.4-fpm-platform-ee-4.1-mysql'), '/path/to/dockerfile/commerce/ee/', '7.4-fpm-commerce-ee-4.1-mysql'),
            new BuildableDependentTag($repository, new TagReference('7.4-cli-platform-ee-4.1-mysql'), '/path/to/dockerfile/commerce/ee/', '7.4-cli-commerce-ee-4.1-mysql'),
        ]));
    }

    public function it_is_buildable(CommandBusInterface $commandBus)
    {
        $repository = new Repository('kiboko/php');
        $ce = new Edition('ce', new Version('3.1', new Variation('postgres', new PHP\Version('7.4', new PHP\Flavor('fpm')))));

        $this->beConstructedWith($repository, 'commerce', 'platform', '/path/to/dockerfile/%package.name%/%package.edition%/', $ce);

        $variables = new BuildableContext(
            null,
            '/path/to/dockerfile/commerce/ce/',
            [
                '%package.name%' => 'commerce',
                '%package.edition%' => 'ce',
                '%php.flavor%' => 'fpm',
                '%php.version%' => '7.4',
                '%package.variation%' => 'postgres',
                '%package.version%' => '3.1',
            ]
        );

        $commandBus->add(Argument::exact(new BuildFrom(
            $repository,
            new TagReference('%php.version%-%php.flavor%-%package.name%-%package.edition%-%package.version%-%package.variation%', $variables),
            new TagReference(
                '%php.version%-%php.flavor%-%package.name%-%package.edition%-%package.version%-%package.variation%',
                new Context($variables, ['%package.name%' => 'platform'] + $variables->getArrayCopy())
            ),
            '/path/to/dockerfile/commerce/ce/'
        )))->shouldBeCalled();

        $this->build($commandBus);
    }

    public function it_follows_child_path(CommandBusInterface $commandBus)
    {
        $repository = new Repository('kiboko/php');
        $ce = new BuildableEdition(
            $repository,
            'ce',
            '/path/to/dockerfile/%package.name%/%package.edition%/',
            new Version('3.1', new Variation('postgres', new PHP\Version('7.4', new PHP\Flavor('fpm'))))
        );

        $this->beConstructedWith(
            $repository,
            'commerce',
            'platform',
            null,
            $ce
        );

        $variables = new BuildableContext(
            null,
            '/path/to/dockerfile/commerce/ce/',
            [
                '%package.name%' => 'commerce',
                '%package.edition%' => 'ce',
                '%php.flavor%' => 'fpm',
                '%php.version%' => '7.4',
                '%package.variation%' => 'postgres',
                '%package.version%' => '3.1',
            ]
        );

        $commandBus->add(Argument::exact(new BuildFrom(
            $repository,
            new TagReference('%php.version%-%php.flavor%-%package.name%-%package.edition%-%package.version%-%package.variation%', $variables),
            new TagReference(
                '%php.version%-%php.flavor%-%package.name%-%package.edition%-%package.version%-%package.variation%',
                new Context($variables, ['%package.name%' => 'platform'] + $variables->getArrayCopy())
            ),
            '/path/to/dockerfile/commerce/ce/'
        )))->shouldBeCalled();

        $this->build($commandBus);
    }
}
