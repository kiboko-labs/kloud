<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Assert;

use Kiboko\Cloud\Domain\Packaging;
use Composer\Semver\Semver;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class CLIConstraint implements AssertionInterface
{
    public Packaging\RepositoryInterface $repository;
    public Packaging\Tag\TagInterface $tag;

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
            'php', '-v',
        ]);

        $version = null;
        try {
            $process->run(function ($type, $buffer) use ($process, &$version) {
                if (Process::ERR === $type) {
                    throw new ProcessFailedException($process);
                }

                if (preg_match('/^PHP\s+(\d+\.\d+\.\d+(?:[\.-](?:alpha|beta|rc)\d+)?)\s+\(cli\)/i', $buffer, $matches)) {
                    $version = $matches[1];
                }
            });
        } catch (ProcessFailedException $exception) {
            return new Result\CLIVersionNotFound($this->tag);
        }

        if (!is_string($version)) {
            return new Result\CLIMissingOrBroken($this->tag);
        }

        return new Result\CLIFound($this->tag, $version);
    }
}
