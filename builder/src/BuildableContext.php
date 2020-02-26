<?php declare(strict_types=1);

namespace Builder;

final class BuildableContext extends \ArrayObject implements BuildableContextInterface
{
    private Placeholder $path;

    public function __construct(?ContextInterface $parent, string $path, array $variables)
    {
        $this->path = $parent instanceof BuildableContextInterface ? $parent->getPath() : new Placeholder($path, $variables);

        parent::__construct($variables);
    }

    public function getPath(): Placeholder
    {
        return $this->path->reset($this->getArrayCopy());
    }
}