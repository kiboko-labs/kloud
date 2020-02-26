<?php

namespace spec\Builder\PHP;

use Builder\Context;
use Builder\PHP;
use Builder\TagReference;
use Builder\TagInterface;
use PhpSpec\ObjectBehavior;

class FlavorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('fpm');

        $this->shouldHaveType(PHP\Flavor::class);
        $this->shouldHaveType(PHP\FlavorInterface::class);
    }

    function it_is_iterable()
    {
        $this->beConstructedWith('fpm');

        $this->shouldIterateTagsLike(new \ArrayIterator([
            new TagReference('fpm')
        ]));
    }
}
