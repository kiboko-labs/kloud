<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Stack\Assertion;

use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\LogicalNot;
use test\Kiboko\Cloud\TestCommandRunner;

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

    public function assertDockerImageExists(string $dockerImage, string $message = ''): void
    {
        $this->assertThat($dockerImage, new DockerImageExists(), $message);
    }

    public function assertDockerImageNotExists(string $dockerImage, string $message = ''): void
    {
        $this->assertThat($dockerImage, new LogicalNot(new DockerImageExists()), $message);
    }

    public function assertCommandRunnerHasRunCommands(TestCommandRunner $commandRunner, array $commands, string $message = ''): void
    {
        $this->assertThat($commands, new CommandRunnerHasRunCommands($commandRunner), $message);
    }

    public function assertCommandRunnerHasNotRunCommand(TestCommandRunner $commandRunner, array $commands, string $message = ''): void
    {
        $this->assertThat($commands, new LogicalNot(new CommandRunnerHasRunCommands($commandRunner)), $message);
    }
}
