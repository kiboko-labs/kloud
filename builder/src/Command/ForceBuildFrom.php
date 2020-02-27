<?php declare(strict_types=1);

namespace Builder\Command;

use Builder\Package;
use Builder\TagInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class ForceBuildFrom implements CommandInterface
{
    private Package\RepositoryInterface $repository;
    private TagInterface $package;
    private TagInterface $source;
    private string $path;

    public function __construct(
        Package\RepositoryInterface $repository,
        TagInterface $package,
        TagInterface $source,
        string $path
    ) {
        $this->repository = $repository;
        $this->package = $package;
        $this->path = $path;
        $this->source = $source;
    }

    public function __toString()
    {
        return sprintf('force build( %1$s:%2$s from %1$s:%3$s )', (string) $this->repository, (string) $this->package, (string) $this->source);
    }

    public function __invoke(): Process
    {
        return new Process(
            [
                'docker', 'build',
                '--no-cache',
                '--tag', sprintf('%s:%s', (string) $this->repository, (string) $this->package),
                '--build-arg', sprintf('SOURCE_VARIATION=%s', (string) $this->source),
                $this->path
            ],
            null,
            null,
            null,
            3600.0
        );
    }
}