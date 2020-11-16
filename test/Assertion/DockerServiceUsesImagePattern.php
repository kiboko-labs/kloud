<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Assertion;

use PHPUnit\Framework\Constraint\Constraint;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Yaml\Yaml;

final class DockerServiceUsesImagePattern extends Constraint
{
    private string $service;
    private string $pattern;
    private PropertyAccessorInterface $accessor;

    public function __construct(string $service, string $pattern)
    {
        $this->service = $service;
        $this->pattern = $pattern;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    protected function matches($other): bool
    {
        $yaml = Yaml::parse(file_get_contents($other));
        if ($yaml === null) {
            return false;
        }

        $imageName = $this->accessor->getValue($yaml, sprintf('[services][%s][image]', $this->service));

        if ($imageName === null) {
            return false;
        }

        return preg_match($this->pattern, $imageName) > 0;
    }

    public function toString(): string
    {
        return 'docker service uses image pattern';
    }

    protected function failureDescription($other): string
    {
        return 'service ' . $this->exporter()->export($this->service)
            . ' declared in file ' . $this->exporter()->export($other)
            . ' uses image pattern ' . $this->exporter()->export($this->pattern);
    }
}
