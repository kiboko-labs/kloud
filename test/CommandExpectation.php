<?php declare(strict_types=1);

namespace test\Kiboko\Cloud;

use Symfony\Component\Process\Process;
use test\Kiboko\Cloud\Fixture\FixtureProviderInterface;
use test\Kiboko\Cloud\Fixture\PlaceholderInterface;

final class CommandExpectation implements \Stringable
{
    private FixtureProviderInterface $context;
    private array $commandline;
    private string $phpVersion;
    private string $applicationVersion;

    public function __construct(FixtureProviderInterface $context, array $commandline, string $phpVersion, string $applicationVersion)
    {
        $this->context = $context;
        $this->commandline = $commandline;
        $this->phpVersion = $phpVersion;
        $this->applicationVersion = $applicationVersion;
    }

    public function getCommandline(): array
    {
        return $this->commandline;
    }

    public function match(Process $process): bool
    {
        $re = new \ReflectionObject($process);
        $property = $re->getProperty('commandline');
        $property->setAccessible(true);

        $iterator = new \MultipleIterator(\MultipleIterator::MIT_NEED_ANY | \MultipleIterator::MIT_KEYS_NUMERIC);
        $iterator->attachIterator(new \ArrayIterator($this->commandline));
        $iterator->attachIterator(new \ArrayIterator($property->getValue($process)));

        foreach ($iterator as list($expected, $actual)) {
            if ($expected instanceof PlaceholderInterface) {
                if (!$expected->matches($this->context, $actual, $this->phpVersion, $this->applicationVersion)) {
                    return false;
                }
            } else if (is_string($expected)) {
                if ($expected !== $actual) {
                    return false;
                }
            } else {
                return false;
            }
        }

        return true;
    }

    public function __toString()
    {
        return implode(' ', array_map(function ($item) {
            return $item instanceof PlaceholderInterface ? $item->toString($this->context, $this->phpVersion, $this->applicationVersion) : sprintf('\'%s\'', (string) $item);
        }, $this->commandline));
    }
}
