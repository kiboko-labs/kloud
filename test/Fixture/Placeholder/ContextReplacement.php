<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Fixture\Placeholder;

use test\Kiboko\Cloud\Fixture\FixtureProviderInterface;
use test\Kiboko\Cloud\Fixture\PlaceholderInterface;

final class ContextReplacement implements PlaceholderInterface
{
    private string $pattern;

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    public function matches(FixtureProviderInterface $context, string $value, string $phpVersion, string $applicationVersion)
    {
        return $value === $this->compile($context, $phpVersion, $applicationVersion);
    }

    public function toString(FixtureProviderInterface $context, string $phpVersion, string $applicationVersion): string
    {
        return sprintf('\'%s\'', $this->compile($context, $phpVersion, $applicationVersion));
    }

    private function compile(FixtureProviderInterface $context, string $phpVersion, string $applicationVersion): string
    {
        return strtr($this->pattern, [
            '%phpVersion%' => $phpVersion,
            '%application%' => $context->getApplication(),
            '%applicationVersion%' => $applicationVersion,
            '%applicationEdition%' => $context->isEnterpriseEdition() ? 'ee' : 'ce',
            '%dbms%' => $context->getDBMS(),
        ]);
    }
}
