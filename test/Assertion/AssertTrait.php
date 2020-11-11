<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Assertion;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * @method assertThat(mixed $actual, Constraint $constraint, string|null $message)
 */
trait AssertTrait
{
    public function assertDockerServiceUsesImagePattern(string $dockerComposePath, string $service, string $pattern, string $message = ''): void
    {
        $this->assertThat($dockerComposePath, new DockerServiceUsesImagePattern($service, $pattern), $message);
    }
}
