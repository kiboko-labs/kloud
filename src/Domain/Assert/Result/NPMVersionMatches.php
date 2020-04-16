<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Assert\Result;

use Kiboko\Cloud\Domain\Packaging;

final class NPMVersionMatches implements AssertionSuccessInterface
{
    private Packaging\Tag\TagInterface $tag;
    private string $version;

    public function __construct(Packaging\Tag\TagInterface $tag, string $version)
    {
        $this->tag = $tag;
        $this->version = $version;
    }

    public function is(Packaging\Tag\TagInterface $tag): bool
    {
        return (string) $tag === (string) $this->tag;
    }

    public function __toString()
    {
        return sprintf('The NPM command was found in version %s.', $this->version);
    }
}
