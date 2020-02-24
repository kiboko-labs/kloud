<?php declare(strict_types=1);

namespace Builder\Command;

use Builder\Package;
use Symfony\Component\Process\Process;

final class Pull implements CommandInterface
{
    private Package\RepositoryInterface $repository;
    private Package\TagInterface $package;

    public function __construct(Package\RepositoryInterface $repository, Package\TagInterface $package)
    {
        $this->repository = $repository;
        $this->package = $package;
    }

    public function __invoke(): void
    {
        $process = new Process([
            'docker', 'pull', sprintf('%s:%s', (string) $this->repository, (string) $this->package),
        ]);

        $process->run();
    }
}