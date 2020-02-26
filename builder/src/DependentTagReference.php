<?php declare(strict_types=1);

namespace Builder;

final class DependentTagReference implements DependentTagInterface
{
    private Placeholder $placeholder;
    private TagInterface $parent;

    public function __construct(TagInterface $parent, string $tag, ?ContextInterface $variables = null)
    {
        $this->placeholder = new Placeholder($tag, ($variables === null ? [] : $variables->getArrayCopy()));
        $this->parent = $parent;
    }

    public function getParent(): TagInterface
    {
        return $this->parent;
    }

    public function __toString()
    {
        return (string) $this->placeholder;
    }
}