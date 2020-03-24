<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Assert;

use Kiboko\Cloud\Domain\Packaging;
use Composer\Semver\Semver;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class PHPExtensionVersionConstraint implements AssertionInterface
{
    public Packaging\RepositoryInterface $repository;
    public Packaging\Tag\TagInterface $tag;
    private string $extension;
    private string $constraint;

    public function __construct(
        Packaging\RepositoryInterface $repository,
        Packaging\Tag\TagInterface $tag,
        string $extension,
        string $constraint
    ) {
        $this->repository = $repository;
        $this->tag = $tag;
        $this->extension = $extension;
        $this->constraint = $constraint;
    }

    public function __invoke(): Result\AssertionResultInterface
    {
        $process = new Process([
            'docker', 'run', '--rm', '-i', sprintf('%s:%s', (string) $this->repository, (string) $this->tag),
            'php', '-r', sprintf('echo (new ReflectionExtension("%1$s"))->getVersion() ?: phpversion("%1$s");', $this->extension),
        ]);

        $version = null;
        try {
            $process->run(function ($type, $buffer) use ($process, &$version) {
                if (Process::ERR === $type) {
                    throw new ProcessFailedException($process);
                }
            });

            if (preg_match('/^(\d+\.\d+(?:\.\d+)?(?:[\.-](?:alpha|beta|rc)\d*)?)/i', $buffer = $process->getOutput(), $matches)) {
                $version = $matches[1];
            }

            if (!$process->isSuccessful()) {
                return new Result\PHPExtensionMissingOrBroken($this->tag, $this->extension);
            }
        } catch (ProcessFailedException $exception) {
            return new Result\PHPExtensionMissingOrBroken($this->tag, $this->extension);
        }

        if (!is_string($version)) {
            if ($this->constraint === '*') {
                return new Result\PHPExtensionFound($this->tag, $this->extension);
            }
            return new Result\PHPExtensionVersionNotFound($this->tag, $this->extension);
        }

        if (Semver::satisfies($version, $this->constraint)) {
            return new Result\PHPExtensionVersionMatches($this->tag, $this->extension, $version, $this->constraint);
        }

        return new Result\PHPExtensionVersionInvalid($this->tag, $this->extension, $version, $this->constraint);
    }
}
