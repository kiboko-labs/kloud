<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Assert;

use Kiboko\Cloud\Domain\Packaging;
use Composer\Semver\Semver;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class ICUVersionConstraint implements AssertionInterface
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
        $program = <<<"EOF"
            try {
                \$reflector = new \ReflectionExtension('intl');
                ob_start();
                \$reflector->info();
                \$output = strip_tags(ob_get_clean());
                preg_match('/^ICU version (?:=>)?(.*)$/m', \$output, \$matches);
                echo trim(\$matches[1]);
            } finally {
            }
            EOF;

        $process = new Process([
            'docker', 'run', '--rm', '-i', sprintf('%s:%s', (string) $this->repository, (string) $this->tag),
            'php', '-r', $program,
        ]);

        $version = null;
        try {
            $process->run(function ($type, $buffer) use ($process, &$version) {
                if (Process::ERR === $type) {
                    throw new ProcessFailedException($process);
                }

                if (preg_match('/^(\d+\.\d+)/i', $buffer, $matches)) {
                    $version = $matches[1];
                }
            });
        } catch (ProcessFailedException $exception) {
            return new Result\ICUMissingOrBroken($this->tag);
        }

        if (!is_string($version)) {
            return new Result\ICUVersionNotFound($this->tag);
        }

        if (Semver::satisfies($version, $this->constraint)) {
            return new Result\ICUVersionMatches($this->tag, $version, $this->constraint);
        }

        return new Result\ICUVersionInvalid($this->tag, $version, $this->constraint);
    }
}
