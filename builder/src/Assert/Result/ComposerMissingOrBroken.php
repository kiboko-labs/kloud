<?php declare(strict_types=1);

namespace Builder\Assert\Result;

use Builder\TagInterface;

final class ComposerMissingOrBroken implements AssertionFailureInterface
{
    private TagInterface $tag;

    public function __construct(TagInterface $tag)
    {
        $this->tag = $tag;
    }

    public function __toString()
    {
        return sprintf('%s: The Composer command is missing or broken.', $this->tag);
    }
}