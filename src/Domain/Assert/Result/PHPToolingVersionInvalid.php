<?php

declare(strict_types=1);

namespace Builder\Domain\Assert\Result;

use Builder\Domain\Packaging;

final class PHPToolingVersionInvalid implements AssertionFailureInterface
{
    private string $toolName;
    private Packaging\Tag\TagInterface $tag;
    private string $version;
    private string $constraint;

    public function __construct(string $toolName, Packaging\Tag\TagInterface $tag, string $version, string $constraint)
    {
        $this->toolName = $toolName;
        $this->tag = $tag;
        $this->version = $version;
        $this->constraint = $constraint;
    }

    public function is(Packaging\Tag\TagInterface $tag): bool
    {
        return (string) $tag === (string) $this->tag;
    }

    public function __toString()
    {
        return sprintf('Version for %s tool chain does not match constraint "%s", found %s.', $this->toolName, $this->constraint, $this->version);
    }
}
