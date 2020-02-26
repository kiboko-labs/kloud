<?php declare(strict_types=1);

namespace Builder;

final class TagReference implements TagInterface
{
    private Placeholder $placeholder;

    public function __construct(string $tag, ?ContextInterface $variables = null)
    {
        $this->placeholder = new Placeholder($tag, ($variables === null ? [] : $variables->getArrayCopy()));
    }

    public function __toString()
    {
        return (string) $this->placeholder;
    }
}