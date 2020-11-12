<?php declare(strict_types=1);

namespace test\Kiboko\Cloud;

use Kiboko\Cloud\Platform\Console\Command;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use test\Kiboko\Cloud\Assertion\AssertTrait;
use Vfs\FileSystem;
use Vfs\Node\Directory;

final class StackInitWithPostgresTest extends TestCase
{
    use AssertTrait;
    use StackInitTraitFixtures;

    private ?FileSystem $fs = null;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->dbms = 'postgresql';
    }

    public function setUp(): void
    {
        $this->fs = FileSystem::factory();
        $this->fs->mount();

        $this->fs->get('/')
            ->add('test', new Directory());
    }

    public function tearDown(): void
    {
        $this->fs->unmount();
        $this->fs = null;
    }

    /**
     * @dataProvider useAll
     */
    public function testSuccessfulWizard($inputOptions, array $desiredOutputs)
    {
        $tester = new CommandTester(
            new Command\Stack\InitCommand(
                Command\Stack\InitCommand::$defaultName,
                __DIR__ . '/empty',
                __DIR__ . '/../environments'
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
        } catch (\Throwable $exception) {
            $this->fail($tester->getDisplay());
        }

        $this->assertEquals(0, $returnCode);

        foreach ($desiredOutputs as $output) {
            $this->assertStringContainsString($output, $tester->getDisplay());
        }

        $this->assertFileExists(sprintf('%s://test/.kloud.yaml', $this->fs->getScheme()));
        $this->assertFileExists(sprintf('%s://test/.env.dist', $this->fs->getScheme()));
        $this->assertFileExists(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()));
    }

    /**
     * @dataProvider useAll
     */
    public function testSuccessfulWizardHavingPostgre($inputOptions, array $desiredOutputs)
    {
        $tester = new CommandTester(
            new Command\Stack\InitCommand(
                Command\Stack\InitCommand::$defaultName,
                __DIR__ . '/empty',
                __DIR__ . '/../environments'
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
        } catch (\Throwable $exception) {
            $this->fail($tester->getDisplay());
        }

        $this->assertEquals(0, $returnCode);

        foreach ($desiredOutputs as $output) {
            $this->assertStringContainsString($output, $tester->getDisplay());
        }

        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'sql', '/^postgres:\d+.\d+-alpine$/');
    }

    /**
     * @dataProvider useWithoutXdebug
     */
    public function testSuccessfulWizardNotHavingXdebug($inputOptions, array $desiredOutputs)
    {
        $tester = new CommandTester(
            new Command\Stack\InitCommand(
                Command\Stack\InitCommand::$defaultName,
                __DIR__ . '/empty',
                __DIR__ . '/../environments'
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
        } catch (\Throwable $exception) {
            $this->fail($tester->getDisplay());
        }

        $this->assertEquals(0, $returnCode);

        foreach ($desiredOutputs as $output) {
            $this->assertStringContainsString($output, $tester->getDisplay());
        }

        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'sh', '/^kiboko\/php:\d+\.\d+-cli-.*-postgresql$/');
        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'fpm', '/^kiboko\/php:\d+\.\d+-fpm-.*-postgresql$/');
        $this->assertDockerServiceNotUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'sh', '/^kiboko\/php:\d+\.\d+-cli-xdebug-.*-postgresql$/');
        $this->assertDockerServiceNotUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'fpm', '/^kiboko\/php:\d+\.\d+-fpm-xdebug-.*-postgresql$/');
    }

    /**
     * @dataProvider useGeneric
     * @dataProvider useWithoutElasticStack
     * @dataProvider useWithoutBlackfire
     */
    public function testSuccessfulWizardHavingXdebug($inputOptions, array $desiredOutputs)
    {
        $tester = new CommandTester(
            new Command\Stack\InitCommand(
                Command\Stack\InitCommand::$defaultName,
                __DIR__ . '/empty',
                __DIR__ . '/../environments'
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
        } catch (\Throwable $exception) {
            $this->fail($tester->getDisplay());
        }

        $this->assertEquals(0, $returnCode);

        foreach ($desiredOutputs as $output) {
            $this->assertStringContainsString($output, $tester->getDisplay());
        }

        $this->assertDockerServiceNotUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'sh', '/^kiboko\/php:\d+\.\d+-cli-xdebug-.*-postgresql$/');
        $this->assertDockerServiceNotUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'fpm', '/^kiboko\/php:\d+\.\d+-fpm-xdebug-.*-postgresql$/');
        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'sh-xdebug', '/^kiboko\/php:\d+\.\d+-cli-xdebug-.*-postgresql$/');
        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'fpm-xdebug', '/^kiboko\/php:\d+\.\d+-fpm-xdebug-.*-postgresql$/');
    }

    /**
     * @dataProvider useWithoutBlackfire
     */
    public function testSuccessfulWizardNotHavingBlackfire($inputOptions, array $desiredOutputs)
    {
        $tester = new CommandTester(
            new Command\Stack\InitCommand(
                Command\Stack\InitCommand::$defaultName,
                __DIR__ . '/empty',
                __DIR__ . '/../environments'
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
        } catch (\Throwable $exception) {
            $this->fail($tester->getDisplay());
        }

        $this->assertEquals(0, $returnCode);

        foreach ($desiredOutputs as $output) {
            $this->assertStringContainsString($output, $tester->getDisplay());
        }

        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'sh', '/^kiboko\/php:\d+\.\d+-cli-.*-postgresql$/');
        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'fpm', '/^kiboko\/php:\d+\.\d+-fpm-.*-postgresql$/');
        $this->assertDockerServiceNotUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'sh', '/^kiboko\/php:\d+\.\d+-cli-blackfire-.*-postgresql$/');
        $this->assertDockerServiceNotUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'fpm', '/^kiboko\/php:\d+\.\d+-fpm-blackfire-.*-postgresql$/');
    }

    /**
     * @dataProvider useGeneric
     * @dataProvider useWithoutElasticStack
     * @dataProvider useWithoutXdebug
     */
    public function testSuccessfulWizardHavingBlackfire($inputOptions, array $desiredOutputs)
    {
        $tester = new CommandTester(
            new Command\Stack\InitCommand(
                Command\Stack\InitCommand::$defaultName,
                __DIR__ . '/empty',
                __DIR__ . '/../environments'
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
        } catch (\Throwable $exception) {
            $this->fail($tester->getDisplay());
        }

        $this->assertEquals(0, $returnCode);

        foreach ($desiredOutputs as $output) {
            $this->assertStringContainsString($output, $tester->getDisplay());
        }

        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'sh', '/^kiboko\/php:\d+\.\d+-cli-blackfire-.*-postgresql$/');
        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'fpm', '/^kiboko\/php:\d+\.\d+-fpm-blackfire-.*-postgresql$/');
    }

    /**
     * @dataProvider useGeneric
     * @dataProvider useWithoutBlackfire
     * @dataProvider useWithoutXdebug
     * @dataProvider useEnterpriseWithoutElasticStack
     */
    public function testSuccessfulWizardHavingElasticSearch($inputOptions)
    {
        $tester = new CommandTester(
            new Command\Stack\InitCommand(
                Command\Stack\InitCommand::$defaultName,
                __DIR__ . '/empty',
                __DIR__ . '/../environments'
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
        } catch (\Throwable $exception) {
            $this->fail($tester->getDisplay());
        }

        $this->assertEquals(0, $returnCode);

        $this->assertFileExists(sprintf('%s://test/.docker/elasticsearch/elasticsearch.yml', $this->fs->getScheme()));
    }

    /**
     * @dataProvider useCommunityWithoutElasticStack
     */
    public function testSuccessfulWizardNotHavingElasticSearch($inputOptions)
    {
        $tester = new CommandTester(
            new Command\Stack\InitCommand(
                Command\Stack\InitCommand::$defaultName,
                __DIR__ . '/empty',
                __DIR__ . '/../environments'
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
        } catch (\Throwable $exception) {
            $this->fail($tester->getDisplay());
        }

        $this->assertEquals(0, $returnCode);

        $this->assertFileNotExists(sprintf('%s://test/.docker/elasticsearch/elasticsearch.yml', $this->fs->getScheme()));
    }

    /**
     * @dataProvider useGeneric
     * @dataProvider useWithoutXdebug
     * @dataProvider useWithoutBlackfire
     */
    public function testSuccessfulWizardHavingKibana($inputOptions)
    {
        $tester = new CommandTester(
            new Command\Stack\InitCommand(
                Command\Stack\InitCommand::$defaultName,
                __DIR__ . '/empty',
                __DIR__ . '/../environments'
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
        } catch (\Throwable $exception) {
            $this->fail($tester->getDisplay());
        }

        $this->assertEquals(0, $returnCode);

        $this->assertFileExists(sprintf('%s://test/.docker/kibana/kibana.yml', $this->fs->getScheme()));
    }

    /**
     * @dataProvider useWithoutElasticStack
     */
    public function testSuccessfulWizardNotHavingKibana($inputOptions)
    {
        $tester = new CommandTester(
            new Command\Stack\InitCommand(
                Command\Stack\InitCommand::$defaultName,
                __DIR__ . '/empty',
                __DIR__ . '/../environments'
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
        } catch (\Throwable $exception) {
            $this->fail($tester->getDisplay());
        }

        $this->assertEquals(0, $returnCode);

        $this->assertFileNotExists(sprintf('%s://test/.docker/kibana/kibana.yml', $this->fs->getScheme()));
    }

    /**
     * @dataProvider useGeneric
     * @dataProvider useWithoutXdebug
     * @dataProvider useWithoutBlackfire
     */
    public function testSuccessfulWizardHavingLogstash($inputOptions)
    {
        $tester = new CommandTester(
            new Command\Stack\InitCommand(
                Command\Stack\InitCommand::$defaultName,
                __DIR__ . '/empty',
                __DIR__ . '/../environments'
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
        } catch (\Throwable $exception) {
            $this->fail($tester->getDisplay());
        }

        $this->assertEquals(0, $returnCode);

        $this->assertFileExists(sprintf('%s://test/.docker/logstash/logstash.yml', $this->fs->getScheme()));
        $this->assertFileExists(sprintf('%s://test/.docker/logstash/pipeline/tcp.conf', $this->fs->getScheme()));
    }

    /**
     * @dataProvider useWithoutElasticStack
     */
    public function testSuccessfulWizardNotHavingLogstash($inputOptions)
    {
        $tester = new CommandTester(
            new Command\Stack\InitCommand(
                Command\Stack\InitCommand::$defaultName,
                __DIR__ . '/empty',
                __DIR__ . '/../environments'
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
        } catch (\Throwable $exception) {
            $this->fail($tester->getDisplay());
        }

        $this->assertEquals(0, $returnCode);

        $this->assertFileNotExists(sprintf('%s://test/.docker/logstash/logstash.yml', $this->fs->getScheme()));
        $this->assertFileNotExists(sprintf('%s://test/.docker/logstash/pipeline/tcp.conf', $this->fs->getScheme()));
    }
}
