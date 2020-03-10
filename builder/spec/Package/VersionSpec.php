<?php

namespace spec\Builder\Package;

use Builder\Package\Variation;
use Builder\Package\VariationInterface;
use Builder\Package\Version;
use Builder\Package\VersionInterface;
use Builder\PHP;
use Builder\Tag\DependentTagReference;
use Builder\Tag\TagReference;
use PhpSpec\ObjectBehavior;

class VersionSpec extends ObjectBehavior
{
    public function it_is_initializable(VariationInterface $variation)
    {
        $this->beConstructedWith('4.1', $variation);

        $this->shouldHaveType(Version::class);
        $this->shouldHaveType(VersionInterface::class);
    }

    public function it_is_iterable()
    {
        $postgres = new Variation('postgres', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli')));
        $mysql = new Variation('mysql', new PHP\Version('7.4', new PHP\Flavor('fpm'), new PHP\Flavor('cli')));

        $this->beConstructedWith('4.1', $postgres, $mysql);

        $this->shouldIterateTagsLike(new \ArrayIterator([
            new DependentTagReference(new TagReference('7.4-fpm-postgres'), '7.4-fpm-4.1-postgres'),
            new DependentTagReference(new TagReference('7.4-cli-postgres'), '7.4-cli-4.1-postgres'),
            new DependentTagReference(new TagReference('7.4-fpm-mysql'), '7.4-fpm-4.1-mysql'),
            new DependentTagReference(new TagReference('7.4-cli-mysql'), '7.4-cli-4.1-mysql'),
        ]));
    }
}
