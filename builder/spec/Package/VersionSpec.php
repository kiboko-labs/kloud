<?php

namespace spec\Builder\Package;

use Builder\DependentTag;
use Builder\Package\Variation;
use Builder\Package\VariationInterface;
use Builder\Package\Version;
use Builder\Package\VersionInterface;
use Builder\PHP;
use Builder\TagReference;
use PhpSpec\ObjectBehavior;

class VersionSpec extends ObjectBehavior
{
    function it_is_initializable(VariationInterface $variation)
    {
        $this->beConstructedWith('4.1', $variation);

        $this->shouldHaveType(Version::class);
        $this->shouldHaveType(VersionInterface::class);
    }

    function it_is_iterable()
    {
        $postgres = new Variation('postgres', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli')));
        $mysql = new Variation('mysql', new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli')));

        $this->beConstructedWith('4.1', $postgres, $mysql);

        $this->shouldIterateLike(new \ArrayIterator([
            new DependentTag('7.4-fpm-4.1-postgres', new TagReference('7.4-fpm-postgres')),
            new DependentTag('7.4-cli-4.1-postgres', new TagReference('7.4-cli-postgres')),
            new DependentTag('7.4-fpm-4.1-mysql', new TagReference('7.4-fpm-mysql')),
            new DependentTag('7.4-cli-4.1-mysql', new TagReference('7.4-cli-mysql')),
        ]));
    }
}
