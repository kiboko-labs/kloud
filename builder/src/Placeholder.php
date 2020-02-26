<?php declare(strict_types=1);

namespace Builder;

final class Placeholder
{
    private string $pattern;
    /** @var array<string,string> */
    private array $variables;

    public function __construct(string $pattern, array $variables = [])
    {
        $this->pattern = $pattern;
        $this->variables = $variables;
    }

    public function reset(array $variables): Placeholder
    {
        return new self($this->pattern, $variables);
    }

    public function merge(array $variables): Placeholder
    {
        return new self($this->pattern, $variables + $this->variables);
    }

    public function __toString()
    {
        return strtr($this->pattern, $this->variables);
    }
}