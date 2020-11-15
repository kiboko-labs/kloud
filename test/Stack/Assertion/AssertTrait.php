<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Stack\Assertion;

use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\LogicalNot;

/**
 * @method assertThat(mixed $actual, Constraint $constraint, string|null $message)
 */
trait AssertTrait
{
    public function assertDockerServiceUsesImagePattern(string $dockerComposePath, string $service, string $pattern, string $message = ''): void
    {
        $this->assertThat($dockerComposePath, new DockerServiceUsesImagePattern($service, $pattern), $message);
    }

    public function assertDockerServiceNotUsesImagePattern(string $dockerComposePath, string $service, string $pattern, string $message = ''): void
    {
        $this->assertThat($dockerComposePath, new LogicalNot(new DockerServiceUsesImagePattern($service, $pattern)), $message);
    }
}
