<?php

namespace spec\Builder\Package;

use Builder\BuildableInterface;
use Builder\Command\BuildFrom;
use Builder\Command\CommandBusInterface;
use Builder\Context\BuildableContext;
use Builder\Context\DependentBuildableContext;
use Builder\Package\BuildableDependentEdition;
use Builder\Package\BuildablePackage;
use Builder\Package\BuildablePackageInterface;
use Builder\Package\Edition;
use Builder\Package\EditionInterface;
use Builder\Package\PackageInterface;
use Builder\Package\Repository;
use Builder\Package\Variation;
use Builder\Package\Version;
use Builder\PHP;
use Builder\Tag\BuildableDependentTag;
use Builder\Tag\TagReference;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BuildablePackageSpec extends ObjectBehavior
{
//    function it_is_initializable(EditionInterface $edition)
//    {
//        $this->beConstructedWith(new Repository('kiboko/php'), 'ee', '/path/to/dockerfile', $edition);
//
//        $this->shouldHaveType(BuildablePackage::class);
//        $this->shouldHaveType(PackageInterface::class);
//        $this->shouldHaveType(BuildableInterface::class);
//        $this->shouldHaveType(BuildablePackageInterface::class);
//    }
//
//    function it_is_iterable()
//    {
//        $repository = new Repository('kiboko/php');
//        $ce = new Edition('ce',
//            new Version('3.1',
//                new Variation('postgres', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
//                new Variation('mysql', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
//            ),new Version('4.1',
//                new Variation('postgres', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
//                new Variation('mysql', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
//            ),
//        );
//        $ee = new Edition('ee',
//            new Version('3.1',
//                new Variation('postgres', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
//                new Variation('mysql', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
//            ),new Version('4.1',
//                new Variation('postgres', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
//                new Variation('mysql', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
//            ),
//        );
//
//        $this->beConstructedWith($repository, 'platform', '/path/to/dockerfile/%package.name%/%package.edition%/', $ce, $ee);
//
//        $this->shouldIterateBuildableTagsLike(new \ArrayIterator([
//            new BuildableDependentTag($repository, new TagReference('7.4-fpm-postgres'), '/path/to/dockerfile/platform/ce/', '7.4-fpm-platform-ce-3.1-postgres'),
//            new BuildableDependentTag($repository, new TagReference('7.4-cli-postgres'), '/path/to/dockerfile/platform/ce/', '7.4-cli-platform-ce-3.1-postgres'),
//            new BuildableDependentTag($repository, new TagReference('7.4-fpm-mysql'), '/path/to/dockerfile/platform/ce/', '7.4-fpm-platform-ce-3.1-mysql'),
//            new BuildableDependentTag($repository, new TagReference('7.4-cli-mysql'), '/path/to/dockerfile/platform/ce/', '7.4-cli-platform-ce-3.1-mysql'),
//            new BuildableDependentTag($repository, new TagReference('7.4-fpm-postgres'), '/path/to/dockerfile/platform/ce/', '7.4-fpm-platform-ce-4.1-postgres'),
//            new BuildableDependentTag($repository, new TagReference('7.4-cli-postgres'), '/path/to/dockerfile/platform/ce/', '7.4-cli-platform-ce-4.1-postgres'),
//            new BuildableDependentTag($repository, new TagReference('7.4-fpm-mysql'), '/path/to/dockerfile/platform/ce/', '7.4-fpm-platform-ce-4.1-mysql'),
//            new BuildableDependentTag($repository, new TagReference('7.4-cli-mysql'), '/path/to/dockerfile/platform/ce/', '7.4-cli-platform-ce-4.1-mysql'),
//            new BuildableDependentTag($repository, new TagReference('7.4-fpm-postgres'), '/path/to/dockerfile/platform/ee/', '7.4-fpm-platform-ee-3.1-postgres'),
//            new BuildableDependentTag($repository, new TagReference('7.4-cli-postgres'), '/path/to/dockerfile/platform/ee/', '7.4-cli-platform-ee-3.1-postgres'),
//            new BuildableDependentTag($repository, new TagReference('7.4-fpm-mysql'), '/path/to/dockerfile/platform/ee/', '7.4-fpm-platform-ee-3.1-mysql'),
//            new BuildableDependentTag($repository, new TagReference('7.4-cli-mysql'), '/path/to/dockerfile/platform/ee/', '7.4-cli-platform-ee-3.1-mysql'),
//            new BuildableDependentTag($repository, new TagReference('7.4-fpm-postgres'), '/path/to/dockerfile/platform/ee/', '7.4-fpm-platform-ee-4.1-postgres'),
//            new BuildableDependentTag($repository, new TagReference('7.4-cli-postgres'), '/path/to/dockerfile/platform/ee/', '7.4-cli-platform-ee-4.1-postgres'),
//            new BuildableDependentTag($repository, new TagReference('7.4-fpm-mysql'), '/path/to/dockerfile/platform/ee/', '7.4-fpm-platform-ee-4.1-mysql'),
//            new BuildableDependentTag($repository, new TagReference('7.4-cli-mysql'), '/path/to/dockerfile/platform/ee/', '7.4-cli-platform-ee-4.1-mysql'),
//        ]));
//    }
//
//    function it_is_buildable(CommandBusInterface $commandBus)
//    {
//        $repository = new Repository('kiboko/php');
//        $ce = new Edition('ce', new Version('3.1', new Variation('postgres', new PHP\VersionReference('7.4', new PHP\Flavor('fpm')))));
//
//        $this->beConstructedWith($repository, 'platform', '/path/to/dockerfile/%package.name%/%package.edition%/', $ce);
//
//        $variables = new BuildableContext(
//            null,
//            '/path/to/dockerfile/platform/ce/',
//            [
//                '%package.name%' => 'platform',
//                '%package.edition%' => 'ce',
//                '%php.flavor%' => 'fpm',
//                '%php.version%' => '7.4',
//                '%package.variation%' => 'postgres',
//                '%package.version%' => '3.1',
//            ]
//        );
//
//        $commandBus->add(Argument::exact(new BuildFrom(
//            $repository,
//            new TagReference('%php.version%-%php.flavor%-%package.name%-%package.edition%-%package.version%-%package.variation%', $variables),
//            new TagReference('%php.version%-%php.flavor%-%package.variation%', $variables),
//            '/path/to/dockerfile/platform/ce/'
//        )))->shouldBeCalled();
//
//        $this->build($commandBus);
//    }
//
//    function it_follows_child_path(CommandBusInterface $commandBus)
//    {
//        $repository = new Repository('kiboko/php');
//        $ce = new BuildableEdition(
//            $repository,
//            'ce',
//            null,
//            new Version('3.1', new Variation('postgres', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'))))
//        );
//
//        $this->beConstructedWith(
//            $repository,
//            'platform',
//            null,
//            $ce
//        );
//
//        $variables = new BuildableContext(
//            null,
//            '/path/to/dockerfile/platform/ce/',
//            [
//                '%package.name%' => 'platform',
//                '%package.edition%' => 'ce',
//                '%php.flavor%' => 'fpm',
//                '%php.version%' => '7.4',
//                '%package.variation%' => 'postgres',
//                '%package.version%' => '3.1',
//            ]
//        );
//
//        $commandBus->add(Argument::exact(new BuildFrom(
//            $repository,
//            new TagReference('%php.version%-%php.flavor%-%package.name%-%package.edition%-%package.version%-%package.variation%', $variables),
//            new TagReference(
//                '%php.version%-%php.flavor%-%package.variation%',
//                new Context($variables, ['%package.name%' => 'platform'] + $variables->getArrayCopy())
//            ),
//            '/path/to/dockerfile/platform/ce/'
//        )))->shouldBeCalled();
//
//        $this->build($commandBus);
//    }

    public function it_builds_from_buildable_parent(CommandBusInterface $commandBus)
    {
        $repository = new Repository('kiboko/php');
        $ce = new BuildableDependentEdition(
            $repository,
            'ee',
            'ce',
            '/path/to/dockerfile/platform/%package.edition%/',
            new Version('3.1', new Variation('postgres', new PHP\Version('7.4', new PHP\Flavor('fpm'))))
        );

        $this->beConstructedWith(
            $repository,
            'platform',
            '/path/to/dockerfile/platform/%package.edition%/',
            $ce
        );

        $dependentContext = new BuildableContext(
            null,
            '/path/to/dockerfile/platform/%package.edition%/',
            [
                '%package.name%' => 'platform',
                '%package.edition%' => 'ce',
                '%package.version%' => '3.1',
                '%package.variation%' => 'postgres',
                '%php.version%' => '7.4',
                '%php.flavor%' => 'fpm',
            ]
        );

        $parentContext = new DependentBuildableContext(
            null,
            $dependentContext,
            '/path/to/dockerfile/platform/%package.edition%/',
            [
                '%package.name%' => 'commerce',
                '%package.edition%' => 'ce',
                '%package.version%' => '3.1',
                '%package.variation%' => 'postgres',
                '%php.version%' => '7.4',
                '%php.flavor%' => 'fpm',
            ]
        );

        $context = new BuildableContext(
            $parentContext,
            '/path/to/dockerfile/platform/%package.edition%/',
            [
                '%package.name%' => 'commerce',
                '%package.edition%' => 'ee',
                '%package.version%' => '3.1',
                '%package.variation%' => 'postgres',
                '%php.version%' => '7.4',
                '%php.flavor%' => 'fpm',
            ]
        );

        $this->shouldIterateBuildableTagsLike(new \ArrayIterator([
            new BuildableDependentTag(
                $repository,
                new TagReference('%php.version%-%php.flavor%-%package.name%-%package.edition%-%package.version%-%package.variation%', $parentContext),
                '/path/to/dockerfile/platform/ee/',
                '%php.version%-%php.flavor%-%package.name%-%package.edition%-%package.version%-%package.variation%',
                $context
            ),
        ]));
    }
}
