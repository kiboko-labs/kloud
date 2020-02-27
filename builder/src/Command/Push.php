<?php declare(strict_types=1);

namespace Builder\Command;

use Builder\Package;
use Builder\TagInterface;
use Symfony\Component\Process\Process;

final class Push implements CommandInterface
{
    private Package\RepositoryInterface $repository;
    private TagInterface $package;

    public function __construct(Package\RepositoryInterface $repository, TagInterface $package)
    {
        $this->repository = $repository;
        $this->package = $package;
    }

    public function __toString()
    {
        return sprintf('push( %s:%s )', (string) $this->repository, (string) $this->package);
    }

    public function __invoke(): Process
    {
        return new Process(
            [
                'docker', 'push', sprintf('%s:%s', (string) $this->repository, (string) $this->package),
            ],
            null,
            null,
            null,
            3600.0
        );
    }
}