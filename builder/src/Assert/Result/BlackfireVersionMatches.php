<?php declare(strict_types=1);

namespace Builder\Assert\Result;

use Builder\TagInterface;

final class BlackfireVersionMatches implements AssertionSuccessInterface
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
        return sprintf('%s: Version for Blackfire command does match constraint "%s", found %s.', $this->tag, $this->constraint, $this->version);
    }
}