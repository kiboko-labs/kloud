<?php

namespace spec\Builder\Package;

use Builder\DependentTagReference;
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

        $this->shouldIterateTagsLike(new \ArrayIterator([
            new DependentTagReference(new TagReference('7.4-fpm-postgres'), '7.4-fpm-4.1-postgres'),
            new DependentTagReference(new TagReference('7.4-cli-postgres'), '7.4-cli-4.1-postgres'),
            new DependentTagReference(new TagReference('7.4-fpm-mysql'), '7.4-fpm-4.1-mysql'),
            new DependentTagReference(new TagReference('7.4-cli-mysql'), '7.4-cli-4.1-mysql'),
        ]));
    }
}
