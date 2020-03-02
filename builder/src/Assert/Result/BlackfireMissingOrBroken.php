<?php declare(strict_types=1);

namespace Builder\Assert\Result;

use Builder\TagInterface;

final class BlackfireMissingOrBroken implements AssertionFailureInterface
{
    private TagInterface $tag;

    public function __construct(TagInterface $tag)
    {
        $this->tag = $tag;
    }

    public function __toString()
    {
        return sprintf('%s: The Blackfire command is missing or broken.', $this->tag);
    }
}