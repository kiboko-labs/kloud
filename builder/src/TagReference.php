<?php declare(strict_types=1);

namespace Builder;

final class TagReference implements TagInterface
{
    private string $tag;

    public function __construct(string $tag)
    {
        $this->tag = $tag;
    }

    public function __toString()
    {
        return $this->tag;
    }
}