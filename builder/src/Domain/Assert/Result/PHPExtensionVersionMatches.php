<?php

declare(strict_types=1);

namespace Builder\Domain\Assert\Result;

use Builder\Domain\Packaging;

final class PHPExtensionVersionMatches implements AssertionSuccessInterface
{
    private Packaging\Tag\TagInterface $tag;
    private string $extension;
    private string $version;
    private string $constraint;

    public function __construct(Packaging\Tag\TagInterface $tag, string $extension, string $version, string $constraint)
    {
        $this->tag = $tag;
        $this->extension = $extension;
        $this->version = $version;
        $this->constraint = $constraint;
    }

    public function is(Packaging\Tag\TagInterface $tag): bool
    {
        return (string) $tag === (string) $this->tag;
    }

    public function __toString()
    {
        return sprintf('%s: Version for PHP extension %s does match constraint "%s", found %s.', $this->tag, $this->extension, $this->constraint, $this->version);
    }
}
