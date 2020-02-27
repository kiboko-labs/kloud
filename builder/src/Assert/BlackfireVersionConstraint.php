<?php declare(strict_types=1);

namespace Builder\Assert;

use Builder\Package\RepositoryInterface;
use Builder\TagInterface;
use Composer\Semver\Semver;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class BlackfireVersionConstraint implements AssertionInterface
{
    private RepositoryInterface $repository;
    private TagInterface $tag;
    private string $constraint;

    public function __construct(RepositoryInterface $repository, TagInterface $tag, string $constraint)
    {
        $this->repository = $repository;
        $this->tag = $tag;
        $this->constraint = $constraint;
    }

    public function __toString()
    {
        return sprintf('Version for Blackfire PHP extension does not match constraint "%s".', $this->constraint);
    }

    public function __invoke(): bool
    {
        $process = new Process([
            'docker', 'run', '--rm', '-i', sprintf('%s:%s', (string)$this->repository, (string)$this->tag),
            'php', '--ri', 'blackfire',
        ]);

        $version = '0';
        $process->run(function ($type, $buffer) use ($process, &$version) {
            if (Process::ERR === $type) {
                throw new ProcessFailedException($process);
            }

            if (preg_match('/Blackfire\s*=>\s*(\d+\.\d+\.\d+(?:[\.-](?:alpha|beta|rc)\d+)?)/i', $buffer, $matches)) {
                $version = $matches[1];
            }
        });

        return Semver::satisfies($version, $this->constraint);
    }
}