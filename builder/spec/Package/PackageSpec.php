<?php

namespace spec\Builder\Package;

use Builder\Package\Edition;
use Builder\Package\EditionInterface;
use Builder\Package\Package;
use Builder\Package\PackageInterface;
use Builder\Package\Variation;
use Builder\Package\Version;
use Builder\PHP;
use Builder\Tag\DependentTagReference;
use Builder\Tag\TagReference;
use PhpSpec\ObjectBehavior;

class PackageSpec extends ObjectBehavior
{
    public function it_is_initializable(EditionInterface $edition)
    {
        $this->beConstructedWith('platform', $edition);

        $this->shouldHaveType(Package::class);
        $this->shouldHaveType(PackageInterface::class);
    }

    public function it_is_iterable()
    {
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

        $this->beConstructedWith('platform', $ce, $ee);

        $this->shouldIterateTagsLike(new \ArrayIterator([
            new DependentTagReference(new TagReference('7.4-fpm-postgres'), '7.4-fpm-platform-ce-3.1-postgres'),
            new DependentTagReference(new TagReference('7.4-cli-postgres'), '7.4-cli-platform-ce-3.1-postgres'),
            new DependentTagReference(new TagReference('7.4-fpm-mysql'), '7.4-fpm-platform-ce-3.1-mysql'),
            new DependentTagReference(new TagReference('7.4-cli-mysql'), '7.4-cli-platform-ce-3.1-mysql'),
            new DependentTagReference(new TagReference('7.4-fpm-postgres'), '7.4-fpm-platform-ce-4.1-postgres'),
            new DependentTagReference(new TagReference('7.4-cli-postgres'), '7.4-cli-platform-ce-4.1-postgres'),
            new DependentTagReference(new TagReference('7.4-fpm-mysql'), '7.4-fpm-platform-ce-4.1-mysql'),
            new DependentTagReference(new TagReference('7.4-cli-mysql'), '7.4-cli-platform-ce-4.1-mysql'),
            new DependentTagReference(new TagReference('7.4-fpm-postgres'), '7.4-fpm-platform-ee-3.1-postgres'),
            new DependentTagReference(new TagReference('7.4-cli-postgres'), '7.4-cli-platform-ee-3.1-postgres'),
            new DependentTagReference(new TagReference('7.4-fpm-mysql'), '7.4-fpm-platform-ee-3.1-mysql'),
            new DependentTagReference(new TagReference('7.4-cli-mysql'), '7.4-cli-platform-ee-3.1-mysql'),
            new DependentTagReference(new TagReference('7.4-fpm-postgres'), '7.4-fpm-platform-ee-4.1-postgres'),
            new DependentTagReference(new TagReference('7.4-cli-postgres'), '7.4-cli-platform-ee-4.1-postgres'),
            new DependentTagReference(new TagReference('7.4-fpm-mysql'), '7.4-fpm-platform-ee-4.1-mysql'),
            new DependentTagReference(new TagReference('7.4-cli-mysql'), '7.4-cli-platform-ee-4.1-mysql'),
        ]));
    }
}
