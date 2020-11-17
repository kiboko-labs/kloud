<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Assertion;

use PHPUnit\Framework\Constraint\Constraint;
use SebastianBergmann\Comparator\ComparisonFailure;
use Symfony\Component\Process\Process;
use test\Kiboko\Cloud\ProcessMatcher;
use test\Kiboko\Cloud\TestCommandRunner;

final class CommandRunnerHasRunCommands extends Constraint
{
    private TestCommandRunner $commandRunner;

    public function __construct(TestCommandRunner $commandRunner)
    {
        $this->commandRunner = $commandRunner;
    }

    private function hasCommand(ProcessMatcher $processPlaceholder): bool
    {
        /** @var Process $process */
        foreach ($this->commandRunner as $process) {
            if (!$processPlaceholder->match($process)) {
                continue;
            }

            return true;
        }

        return false;
    }

    public function evaluate($other, string $description = '', bool $returnResult = false)
    {
        foreach ($other as $command) {
            if (!$this->hasCommand($command)) {
                $this->fail(
                    $other,
                    'The desired command was not found in the expected commands list.',
                    new ComparisonFailure(
                        $other,
                        iterator_to_array($this->commandRunner),
                        $command,
                        implode(' ', array_map(function (Process $command) {
                            return $this->exporter()->export($command->getCommandLine());
                        }, iterator_to_array($this->commandRunner)))
                    )
                );

                return false;
            }
        }

        return true;
    }

    protected function failureDescription($other): string
    {
        return ' the desired executed processes list ' . $this->exporter()->export(array_map(function (ProcessMatcher $command) {
                return $this->exporter()->export($command->getCommandLine());
            }, $other))
            . ' matches the actually executed processes list '
            . $this->exporter()->export(array_map(function (Process $command) {
                return $this->exporter()->export($command->getCommandLine());
            }, iterator_to_array($this->commandRunner)));
    }

    public function toString(): string
    {
        return 'command runner has run command';
    }
}
