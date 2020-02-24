<?php declare(strict_types=1);

namespace Builder;

use Builder\Command\Build;
use Builder\Command\CommandInterface;
use Builder\Package\RepositoryInterface;

final class BuildableTag implements TagInterface, BuildableInterface
{
    private RepositoryInterface $repository;
    public string $tag;
    public string $path;

    public function __construct(RepositoryInterface $repository, string $tag, string $path)
    {
        $this->repository = $repository;
        $this->tag = $tag;
        $this->path = $path;
    }

    public function build(): CommandInterface
    {
        return new Build($this->repository, $this, $this->path);
    }

    public function __toString()
    {
        return $this->tag;
    }
}