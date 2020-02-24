<?php

namespace spec\Builder\Package;

use Builder\DependentTag;
use Builder\Package\DependentPackage;
use Builder\Package\Edition;
use Builder\Package\EditionInterface;
use Builder\Package\PackageInterface;
use Builder\Package\Variation;
use Builder\Package\Version;
use Builder\PHP;
use Builder\TagReference;
use PhpSpec\ObjectBehavior;

class DependentPackageSpec extends ObjectBehavior
{
    function it_is_initializable(EditionInterface $edition)
    {
        $this->beConstructedWith('commerce', 'platform', $edition);

        $this->shouldHaveType(DependentPackage::class);
        $this->shouldHaveType(PackageInterface::class);
    }

    function it_is_iterable()
    {
        $ee = new Edition(
            'ee',
            new Version('3.1',
                new Variation('postgres', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
                new Variation('mysql', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
            ),
            new Version('4.1',
                new Variation('postgres', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
                new Variation('mysql', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
            )
        );
        $ce = new Edition(
            'ce',
            new Version('3.1',
                new Variation('postgres', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
                new Variation('mysql', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
            ),
            new Version('4.1',
                new Variation('postgres', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
                new Variation('mysql', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
            )
        );

        $this->beConstructedWith('commerce', 'platform', $ee, $ce);

        $this->shouldIterateLike(new \ArrayIterator([
            new DependentTag('7.4-fpm-commerce-ee-3.1-postgres', new TagReference('7.4-fpm-platform-ee-3.1-postgres')),
            new DependentTag('7.4-cli-commerce-ee-3.1-postgres', new TagReference('7.4-cli-platform-ee-3.1-postgres')),
            new DependentTag('7.4-fpm-commerce-ee-3.1-mysql', new TagReference('7.4-fpm-platform-ee-3.1-mysql')),
            new DependentTag('7.4-cli-commerce-ee-3.1-mysql', new TagReference('7.4-cli-platform-ee-3.1-mysql')),
            new DependentTag('7.4-fpm-commerce-ee-4.1-postgres', new TagReference('7.4-fpm-platform-ee-4.1-postgres')),
            new DependentTag('7.4-cli-commerce-ee-4.1-postgres', new TagReference('7.4-cli-platform-ee-4.1-postgres')),
            new DependentTag('7.4-fpm-commerce-ee-4.1-mysql', new TagReference('7.4-fpm-platform-ee-4.1-mysql')),
            new DependentTag('7.4-cli-commerce-ee-4.1-mysql', new TagReference('7.4-cli-platform-ee-4.1-mysql')),
            new DependentTag('7.4-fpm-commerce-ce-3.1-postgres', new TagReference('7.4-fpm-platform-ce-3.1-postgres')),
            new DependentTag('7.4-cli-commerce-ce-3.1-postgres', new TagReference('7.4-cli-platform-ce-3.1-postgres')),
            new DependentTag('7.4-fpm-commerce-ce-3.1-mysql', new TagReference('7.4-fpm-platform-ce-3.1-mysql')),
            new DependentTag('7.4-cli-commerce-ce-3.1-mysql', new TagReference('7.4-cli-platform-ce-3.1-mysql')),
            new DependentTag('7.4-fpm-commerce-ce-4.1-postgres', new TagReference('7.4-fpm-platform-ce-4.1-postgres')),
            new DependentTag('7.4-cli-commerce-ce-4.1-postgres', new TagReference('7.4-cli-platform-ce-4.1-postgres')),
            new DependentTag('7.4-fpm-commerce-ce-4.1-mysql', new TagReference('7.4-fpm-platform-ce-4.1-mysql')),
            new DependentTag('7.4-cli-commerce-ce-4.1-mysql', new TagReference('7.4-cli-platform-ce-4.1-mysql')),
        ]));
    }
}
