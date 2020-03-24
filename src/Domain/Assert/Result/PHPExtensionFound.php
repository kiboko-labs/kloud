<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Assert\Result;

use Kiboko\Cloud\Domain\Packaging;

final class PHPExtensionFound implements AssertionSuccessInterface
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
        return sprintf('The PHP extension %s was found, but no version information was provided.', $this->extension);
    }
}
