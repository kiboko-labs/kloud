<?php

namespace spec\Builder\PHP;

use Builder\PHP\Flavor;
use Builder\PHP\FlavorInterface;
use Builder\PHP\VersionReference;
use Builder\PHP\VersionInterface;
use Builder\TagReference;
use PhpSpec\ObjectBehavior;

class VersionSpec extends ObjectBehavior
{
    function it_is_initializable(FlavorInterface $flavor)
    {
        $this->beConstructedWith('7.4', $flavor);

        $this->shouldHaveType(VersionReference::class);
        $this->shouldHaveType(VersionInterface::class);
    }

    function it_is_iterable()
    {
        $fpm = new Flavor('fpm');
        $cli = new Flavor('cli');

        $this->beConstructedWith('7.4', $fpm, $cli);

        $this->shouldIterateLike(new \ArrayIterator([
            new TagReference('7.4-fpm'),
            new TagReference('7.4-cli'),
        ]));
    }
}
