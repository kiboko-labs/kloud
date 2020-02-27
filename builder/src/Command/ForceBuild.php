<?php declare(strict_types=1);

namespace Builder\Command;

use Builder\Package;
use Builder\TagInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class ForceBuild implements CommandInterface
{
    private Package\RepositoryInterface $repository;
    private TagInterface $package;
    private string $path;

    public function __construct(
        Package\RepositoryInterface $repository,
        TagInterface $tag,
        string $path
    ) {
        $this->repository = $repository;
        $this->package = $tag;
        $this->path = $path;
    }

    public function __toString()
    {
        return sprintf('force build( %s:%s )', (string) $this->repository, (string) $this->package);
    }

    public function __invoke(): Process
    {
        return new Process(
            [
                'docker', 'build',
                '--no-cache',
                '--tag', sprintf('%s:%s', (string) $this->repository, (string) $this->package),
                $this->path,
            ],
            null,
            null,
            null,
            3600.0
        );
    }
}