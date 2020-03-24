<?php

declare(strict_types=1);

namespace Builder\Domain\Assert\Result;

use Builder\Domain\Packaging;

final class PHPExtensionMissingOrBroken implements AssertionFailureInterface
{
    private Packaging\Tag\TagInterface $tag;
    private string $extension;

    public function __construct(Packaging\Tag\TagInterface $tag, string $extension)
    {
        $this->tag = $tag;
        $this->extension = $extension;
    }

    public function is(Packaging\Tag\TagInterface $tag): bool
    {
        return (string) $tag === (string) $this->tag;
    }

    public function __toString()
    {
        return sprintf('The PHP extension %s is missing or broken.', $this->extension);
    }
}
