<?php

namespace spec\Builder\Package;

use Builder\Package\PackageWithDependency;
use Builder\Package\Edition;
use Builder\Package\EditionInterface;
use Builder\Package\PackageInterface;
use Builder\Package\Variation;
use Builder\Package\Version;
use Builder\PHP;
use Builder\Tag\DependentTagReference;
use Builder\Tag\TagReference;
use PhpSpec\ObjectBehavior;

class DependentPackageSpec extends ObjectBehavior
{
    public function it_is_initializable(EditionInterface $edition)
    {
        $this->beConstructedWith('commerce', 'platform', $edition);

        $this->shouldHaveType(PackageWithDependency::class);
        $this->shouldHaveType(PackageInterface::class);
    }

    public function it_is_iterable()
    {
        $ee = new Edition(
            'ee',
            new Version('3.1',
                new Variation('postgres', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
                new Variation('mysql', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
            ),
            new Version('4.1',
                new Variation('postgres', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
                new Variation('mysql', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
            )
        );
        $ce = new Edition(
            'ce',
            new Version('3.1',
                new Variation('postgres', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
                new Variation('mysql', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
            ),
            new Version('4.1',
                new Variation('postgres', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
                new Variation('mysql', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
            )
        );

        $this->beConstructedWith('commerce', 'platform', $ee, $ce);

        $this->shouldIterateTagsLike(new \ArrayIterator([
            new DependentTagReference(new TagReference('7.4-fpm-platform-ee-3.1-postgres'), '7.4-fpm-commerce-ee-3.1-postgres'),
            new DependentTagReference(new TagReference('7.4-cli-platform-ee-3.1-postgres'), '7.4-cli-commerce-ee-3.1-postgres'),
            new DependentTagReference(new TagReference('7.4-fpm-platform-ee-3.1-mysql'), '7.4-fpm-commerce-ee-3.1-mysql'),
            new DependentTagReference(new TagReference('7.4-cli-platform-ee-3.1-mysql'), '7.4-cli-commerce-ee-3.1-mysql'),
            new DependentTagReference(new TagReference('7.4-fpm-platform-ee-4.1-postgres'), '7.4-fpm-commerce-ee-4.1-postgres'),
            new DependentTagReference(new TagReference('7.4-cli-platform-ee-4.1-postgres'), '7.4-cli-commerce-ee-4.1-postgres'),
            new DependentTagReference(new TagReference('7.4-fpm-platform-ee-4.1-mysql'), '7.4-fpm-commerce-ee-4.1-mysql'),
            new DependentTagReference(new TagReference('7.4-cli-platform-ee-4.1-mysql'), '7.4-cli-commerce-ee-4.1-mysql'),
            new DependentTagReference(new TagReference('7.4-fpm-platform-ce-3.1-postgres'), '7.4-fpm-commerce-ce-3.1-postgres'),
            new DependentTagReference(new TagReference('7.4-cli-platform-ce-3.1-postgres'), '7.4-cli-commerce-ce-3.1-postgres'),
            new DependentTagReference(new TagReference('7.4-fpm-platform-ce-3.1-mysql'), '7.4-fpm-commerce-ce-3.1-mysql'),
            new DependentTagReference(new TagReference('7.4-cli-platform-ce-3.1-mysql'), '7.4-cli-commerce-ce-3.1-mysql'),
            new DependentTagReference(new TagReference('7.4-fpm-platform-ce-4.1-postgres'), '7.4-fpm-commerce-ce-4.1-postgres'),
            new DependentTagReference(new TagReference('7.4-cli-platform-ce-4.1-postgres'), '7.4-cli-commerce-ce-4.1-postgres'),
            new DependentTagReference(new TagReference('7.4-fpm-platform-ce-4.1-mysql'), '7.4-fpm-commerce-ce-4.1-mysql'),
            new DependentTagReference(new TagReference('7.4-cli-platform-ce-4.1-mysql'), '7.4-cli-commerce-ce-4.1-mysql'),
        ]));
    }
}
