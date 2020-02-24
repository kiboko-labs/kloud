<?php declare(strict_types=1);

namespace Builder;

use Builder\Command\Build;
use Builder\Command\BuildFrom;
use Builder\Command\CommandInterface;
use Builder\Package\RepositoryInterface;

final class BuildableDependentTag implements DependentTagInterface, BuildableInterface
{
    private RepositoryInterface $repository;
    public string $tag;
    public TagInterface $parent;
    public string $path;

    public function __construct(RepositoryInterface $repository, string $tag, TagInterface $parent, string $path)
    {
        $this->repository = $repository;
        $this->tag = $tag;
        $this->parent = $parent;
        $this->path = $path;
    }

    public function build(): CommandInterface
    {
        return new BuildFrom($this->repository, $this, $this->parent, $this->path);
    }

    public function __toString()
    {
        return $this->tag;
    }
}