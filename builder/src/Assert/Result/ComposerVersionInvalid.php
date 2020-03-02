<?php declare(strict_types=1);

namespace Builder\Assert\Result;

use Builder\TagInterface;

final class ComposerVersionInvalid implements AssertionFailureInterface
{
    private TagInterface $tag;
    private string $version;
    private string $constraint;

    public function __construct(TagInterface $tag, string $version, string $constraint)
    {
        $this->tag = $tag;
        $this->version = $version;
        $this->constraint = $constraint;
    }

    public function __toString()
    {
        return sprintf('%s: Version for Composer command does not match constraint "%s", found %s.', $this->tag, $this->constraint, $this->version);
    }
}