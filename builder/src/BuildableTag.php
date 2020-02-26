<?php declare(strict_types=1);

namespace Builder;

use Builder\Command;
use Builder\Package\RepositoryInterface;

final class BuildableTag implements BuildableTagInterface
{
    private RepositoryInterface $repository;
    private Placeholder $path;
    private Placeholder $tag;

    public function __construct(RepositoryInterface $repository, string $path, string $tag, ?ContextInterface $variables = null)
    {
        $this->repository = $repository;
        $this->path = new Placeholder($path, ($variables === null ? [] : $variables->getArrayCopy()));
        $this->tag = new Placeholder($tag, ($variables === null ? [] : $variables->getArrayCopy()));
    }

    public function getPath(): string
    {
        return (string) $this->path;
    }

    public function pull(Command\CommandCompositeInterface $commands): void
    {
        $commands->add(new Command\Pull($this->repository, $this));
    }

    public function push(Command\CommandCompositeInterface $commands): void
    {
        $commands->add(new Command\Push($this->repository, $this));
    }

    public function build(Command\CommandCompositeInterface $commands): void
    {
        $commands->add(new Command\Build($this->repository, $this, $this->getPath()));
    }

    public function __toString()
    {
        return (string) $this->tag;
    }
}