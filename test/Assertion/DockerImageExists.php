<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Assertion;

use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Component\Process\Process;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Yaml\Yaml;

final class DockerImageExists extends Constraint
{
    protected function matches($other): bool
    {
        $process = new Process(['docker', 'image', '-q', $other]);

        $process->run();

        return 0 === $process->getExitCode();
    }

    public function toString(): string
    {
        return 'docker image exists';
    }
}
