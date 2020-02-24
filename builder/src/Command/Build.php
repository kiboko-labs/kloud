<?php declare(strict_types=1);

namespace Builder\Command;

use Builder\Package;
use Builder\TagInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class Build implements CommandInterface
{
    private Package\RepositoryInterface $repository;
    private TagInterface $tag;
    private string $path;

    public function __construct(
        Package\RepositoryInterface $repository,
        TagInterface $tag,
        string $path
    ) {
        $this->repository = $repository;
        $this->tag = $tag;
        $this->path = $path;
    }

    public function __invoke(): void
    {
        $process = new Process([
            'docker', 'build',
            '--tag', sprintf('%s:%s', (string) $this->repository, (string) $this->tag),
            $this->path,
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
    }
}