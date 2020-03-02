<?php declare(strict_types=1);

namespace Builder;

final class BuildableContext extends \ArrayObject implements BuildableContextInterface
{
    private Placeholder $path;

    public function __construct(?ContextInterface $parent, ?string $path, array $variables)
    {
        if ($path === null && !$parent instanceof BuildableContextInterface) {
            throw new \RuntimeException('Could not determine path from parent context.');
        }

        $this->path = ($path === null && $parent instanceof BuildableContextInterface)
            ? $parent->getPath()->reset($variables)
            : new Placeholder($path, $variables);

        parent::__construct($variables);
    }

    public function getPath(): Placeholder
    {
        return $this->path->reset($this->getArrayCopy());
    }
}