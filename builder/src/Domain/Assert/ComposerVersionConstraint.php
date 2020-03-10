<?php

declare(strict_types=1);

namespace Builder\Domain\Assert;

use Builder\Domain\Packaging;
use Composer\Semver\Semver;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class ComposerVersionConstraint implements AssertionInterface
{
    private Packaging\RepositoryInterface $repository;
    private Packaging\Tag\TagInterface $tag;
    private string $constraint;

    public function __construct(
        Packaging\RepositoryInterface $repository,
        Packaging\Tag\TagInterface $tag,
        string $constraint
    ) {
        $this->repository = $repository;
        $this->tag = $tag;
        $this->constraint = $constraint;
    }

    public function __invoke(): Result\AssertionResultInterface
    {
        $process = new Process([
            'docker', 'run', '--rm', '-i', sprintf('%s:%s', (string) $this->repository, (string) $this->tag),
            'composer', '--version',
        ]);

        $version = null;
        try {
            $process->run(function ($type, $buffer) use ($process, &$version) {
                if (Process::ERR === $type) {
                    throw new ProcessFailedException($process);
                }

                if (preg_match('/^Composer\s+version\s+(\d+\.\d+\.\d+(?:[\.-](?:alpha|beta|rc)\d+)?)/i', $buffer, $matches)) {
                    $version = $matches[1];
                }
            });
        } catch (ProcessFailedException $exception) {
            return new Result\ComposerMissingOrBroken($this->tag);
        }

        if (!is_string($version)) {
            return new Result\ComposerMissingOrBroken($this->tag);
        }

        if (Semver::satisfies($version, $this->constraint)) {
            return new Result\ComposerVersionMatches($this->tag, $version, $this->constraint);
        }

        return new Result\ComposerVersionInvalid($this->tag, $version, $this->constraint);
    }
}
