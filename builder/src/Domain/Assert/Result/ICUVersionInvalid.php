<?php

declare(strict_types=1);

namespace Builder\Domain\Assert\Result;

use Builder\Domain\Packaging;

final class ICUVersionInvalid implements AssertionFailureInterface
{
    private Packaging\Tag\TagInterface $tag;
    private string $version;
    private string $constraint;

    public function __construct(Packaging\Tag\TagInterface $tag, string $version, string $constraint)
    {
        $this->tag = $tag;
        $this->version = $version;
        $this->constraint = $constraint;
    }

    public function __toString()
    {
        return sprintf('%s: Version for ICU library does not match constraint "%s", found %s.', $this->tag, $this->constraint, $this->version);
    }
}
