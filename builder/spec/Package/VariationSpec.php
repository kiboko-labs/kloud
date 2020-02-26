<?php

namespace spec\Builder\Package;

use Builder\DependentTagReference;
use Builder\Package\Variation;
use Builder\Package\VariationInterface;
use Builder\PHP;
use Builder\TagReference;
use PhpSpec\ObjectBehavior;

class VariationSpec extends ObjectBehavior
{
    function it_is_initializable(PHP\VersionInterface $version)
    {
        $this->beConstructedWith('postgres', $version);

        $this->shouldHaveType(Variation::class);
        $this->shouldHaveType(VariationInterface::class);
    }

    function it_is_iterable()
    {
        $php73 = new PHP\VersionReference('7.3', new PHP\Flavor('fpm'), new PHP\Flavor('cli'));
        $php74 = new PHP\VersionReference('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli'));

        $this->beConstructedWith('postgres', $php73, $php74);

        $this->shouldIterateTagsLike(new \ArrayIterator([
            new DependentTagReference(new TagReference('7.3-fpm'), '7.3-fpm-postgres'),
            new DependentTagReference(new TagReference('7.3-cli'), '7.3-cli-postgres'),
            new DependentTagReference(new TagReference('7.4-fpm'), '7.4-fpm-postgres'),
            new DependentTagReference(new TagReference('7.4-cli'), '7.4-cli-postgres'),
        ]));
    }
}
