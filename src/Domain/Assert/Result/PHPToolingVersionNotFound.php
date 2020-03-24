<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Assert\Result;

use Kiboko\Cloud\Domain\Packaging;

final class PHPToolingVersionNotFound implements AssertionUnprocessableInterface
{
    private string $toolName;
    private Packaging\Tag\TagInterface $tag;

    public function __construct(string $toolName, Packaging\Tag\TagInterface $tag)
    {
        $this->toolName = $toolName;
        $this->tag = $tag;
    }

    public function is(Packaging\Tag\TagInterface $tag): bool
    {
        return (string) $tag === (string) $this->tag;
    }

    public function __toString()
    {
        return sprintf('Could not determine the %s tool chain version, although the tool was found.', $this->toolName);
    }
}
