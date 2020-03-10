<?php

declare(strict_types=1);

namespace Builder\Domain\Assert\Result;

use Builder\Domain\Packaging;

final class ComposerMissingOrBroken implements AssertionFailureInterface
{
    private Packaging\Tag\TagInterface $tag;

    public function __construct(Packaging\Tag\TagInterface $tag)
    {
        $this->tag = $tag;
    }

    public function __toString()
    {
        return sprintf('%s: The Composer command is missing or broken.', $this->tag);
    }
}
