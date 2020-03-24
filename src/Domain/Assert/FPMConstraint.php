<?php

declare(strict_types=1);

namespace Builder\Domain\Assert;

use Builder\Domain\Packaging;
use Composer\Semver\Semver;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class FPMConstraint implements AssertionInterface
{
    private Packaging\RepositoryInterface $repository;
    private Packaging\Tag\TagInterface $tag;

    public function __construct(
        Packaging\RepositoryInterface $repository,
        Packaging\Tag\TagInterface $tag
    ) {
        $this->repository = $repository;
        $this->tag = $tag;
    }

    public function __invoke(): Result\AssertionResultInterface
    {
        $process = new Process([
            'docker', 'run', '--rm', '-i', sprintf('%s:%s', (string) $this->repository, (string) $this->tag),
            'php-fpm', '-v',
        ]);

        $version = null;
        try {
            $process->run(function ($type, $buffer) use ($process, &$version) {
                if (Process::ERR === $type) {
                    throw new ProcessFailedException($process);
                }

                if (preg_match('/^PHP\s+(\d+\.\d+\.\d+(?:[\.-](?:alpha|beta|rc)\d+)?) \(fpm-fcgi\)/i', $buffer, $matches)) {
                    $version = $matches[1];
                }
            });
        } catch (ProcessFailedException $exception) {
            return new Result\FPMVersionNotFound($this->tag);
        }

        if (!is_string($version)) {
            return new Result\FPMMissingOrBroken($this->tag);
        }

        return new Result\FPMFound($this->tag, $version);
    }
}
