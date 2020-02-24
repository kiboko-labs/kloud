<?php

namespace spec\Builder\Package;

use Builder\DependentTag;
use Builder\Package\Edition;
use Builder\Package\EditionInterface;
use Builder\Package\Variation;
use Builder\Package\Version;
use Builder\Package\VersionInterface;
use Builder\PHP;
use Builder\TagReference;
use PhpSpec\ObjectBehavior;

class EditionSpec extends ObjectBehavior
{
    function it_is_initializable(VersionInterface $version)
    {
        $this->beConstructedWith('ee', $version);

        $this->shouldHaveType(Edition::class);
        $this->shouldHaveType(EditionInterface::class);
    }

    function it_is_iterable()
    {
        $v31 = new Version('3.1',
            new Variation('postgres', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
            new Variation('mysql', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
        );
        $v41 = new Version('4.1',
            new Variation('postgres', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
            new Variation('mysql', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'))),
        );

        $this->beConstructedWith('ee', $v31, $v41);

        $this->shouldIterateLike(new \ArrayIterator([
            new DependentTag('7.4-fpm-ee-3.1-postgres', new TagReference('7.4-fpm-postgres')),
            new DependentTag('7.4-cli-ee-3.1-postgres', new TagReference('7.4-cli-postgres')),
            new DependentTag('7.4-fpm-ee-3.1-mysql', new TagReference('7.4-fpm-mysql')),
            new DependentTag('7.4-cli-ee-3.1-mysql', new TagReference('7.4-cli-mysql')),
            new DependentTag('7.4-fpm-ee-4.1-postgres', new TagReference('7.4-fpm-postgres')),
            new DependentTag('7.4-cli-ee-4.1-postgres', new TagReference('7.4-cli-postgres')),
            new DependentTag('7.4-fpm-ee-4.1-mysql', new TagReference('7.4-fpm-mysql')),
            new DependentTag('7.4-cli-ee-4.1-mysql', new TagReference('7.4-cli-mysql')),
        ]));
    }
}
