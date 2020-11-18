<?php declare(strict_types=1);

namespace test\Kiboko\Cloud\Image;

use Kiboko\Cloud\Platform\Console\Command;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Process\Process;
use test\Kiboko\Cloud\Assertion\AssertTrait;
use test\Kiboko\Cloud\Fixture;
use test\Kiboko\Cloud\TestCommandRunner;
use Vfs\FileSystem;
use Vfs\Node\Directory;

final class ImageBuildWithMySQLTest extends TestCase
{
    use AssertTrait;
    use Fixture\CloudFixtures;

    private ?FileSystem $fs = null;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->dbms = 'mysql';
    }

    public function setUp(): void
    {
        $this->fs = FileSystem::factory();
        $this->fs->mount();

        $this->fs->get('/')
            ->add('test', new Directory());

        if (!$this->dropImages(...$this->listImages('kiboko-test/php'))) {
            $this->markTestIncomplete('Could not delete the Docker image tags for kiboko-test/php image.');
        }
    }

    private function listImages(string $image): iterable
    {
        $process = new Process(['docker', 'images', '-q', $image]);

        $process->run();

        return array_filter(explode(PHP_EOL, $process->getOutput()));
    }

    private function dropImages(string ...$identifiers): bool
    {
        if (count($identifiers) <= 0) {
            return true;
        }
        $process = new Process(['docker', 'rmi', ...$identifiers]);

        $process->run();

        return 0 === $process->getExitCode();
    }

    public function tearDown(): void
    {
        $this->fs->unmount();
        $this->fs = null;
    }

    /**
     * @dataProvider useAll
     */
    public function testSuccessfulWizard(array $inputOptions, array $desiredOutputs, array $desiredProcesses)
    {
        $tester = new CommandTester(
            new Command\Images\BuildCommand(
                $commandRunner = new TestCommandRunner(),
                __DIR__ . '/../../config',
                __DIR__ . '/../../environments',
                Command\Images\BuildCommand::$defaultName,
            )
        );

        try {
            $returnCode = $tester->execute(
                array_merge(
                    [
                        '--working-directory' => sprintf('%s://test', $this->fs->getScheme())
                    ],
                    $inputOptions
                )
            );
        } catch (Exception|\UnexpectedValueException $exception) {
            $this->fail($exception->getMessage());
        } catch (\Throwable $exception) {
            $this->fail($tester->getDisplay());
        }

        $this->assertEquals(0, $returnCode);

        foreach ($desiredOutputs as $output) {
            $this->assertStringContainsString($output, $tester->getDisplay());
        }

        $this->assertCommandRunnerHasRunCommands($commandRunner, $desiredProcesses);
    }
}
