<?php declare(strict_types=1);

namespace Builder;

final class DependentTag implements DependentTagInterface
{
    public string $tag;
    public TagInterface $parent;

    public function __construct(string $tag, TagInterface $parent)
    {
        $this->tag = $tag;
        $this->parent = $parent;
    }

    public function __toString()
    {
        return $this->tag;
    }
}