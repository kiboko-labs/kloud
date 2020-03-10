<?php

namespace spec\Builder\PHP;

use Builder\PHP\Flavor;
use Builder\PHP\FlavorInterface;
use Builder\PHP\VersionInterface;
use Builder\PHP\Version;
use Builder\Tag\TagReference;
use PhpSpec\ObjectBehavior;

class VersionReferenceSpec extends ObjectBehavior
{
    public function it_is_initializable(FlavorInterface $flavor)
    {
        $this->beConstructedWith('7.4', $flavor);

        $this->shouldHaveType(Version::class);
        $this->shouldHaveType(VersionInterface::class);
    }

    public function it_is_iterable()
    {
        $fpm = new Flavor('fpm');
        $cli = new Flavor('cli');

        $this->beConstructedWith('7.4', $fpm, $cli);

        $this->shouldIterateTagsLike(new \ArrayIterator([
            new TagReference('7.4-fpm'),
            new TagReference('7.4-cli'),
        ]));
    }
}
