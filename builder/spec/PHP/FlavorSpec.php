<?php

namespace spec\Builder\PHP;

use Builder\PHP;
use Builder\Tag\TagReference;
use PhpSpec\ObjectBehavior;

class FlavorSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith('fpm');

        $this->shouldHaveType(PHP\Flavor::class);
        $this->shouldHaveType(PHP\FlavorInterface::class);
    }

    public function it_is_iterable()
    {
        $this->beConstructedWith('fpm');

        $this->shouldIterateTagsLike(new \ArrayIterator([
            new TagReference('fpm'),
        ]));
    }
}
