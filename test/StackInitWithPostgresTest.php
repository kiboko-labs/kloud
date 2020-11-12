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
     * @dataProvider useOroCommerceEnterprise
     * @dataProvider useOroCommerceEnterpriseWithoutElasticStack
     * @dataProvider useOroCommerceEnterpriseWithoutXdebug
     * @dataProvider useOroCommerceEnterpriseWithoutBlackfire
     * @dataProvider useOroCommerceCommunity
     * @dataProvider useOroCommerceCommunityWithoutElasticStack
     * @dataProvider useOroCommerceCommunityWithoutXdebug
     * @dataProvider useOroCommerceCommunityWithoutBlackfire
     * @dataProvider useOroCRMEnterprise
     * @dataProvider useOroCRMEnterpriseWithoutElasticStack
     * @dataProvider useOroCRMEnterpriseWithoutXdebug
     * @dataProvider useOroCRMEnterpriseWithoutBlackfire
     * @dataProvider useOroCRMCommunity
     * @dataProvider useOroCRMCommunityWithoutElasticStack
     * @dataProvider useOroCRMCommunityWithoutXdebug
     * @dataProvider useOroCRMCommunityWithoutBlackfire
     * @dataProvider useOroPlatformEnterprise
     * @dataProvider useOroPlatformEnterpriseWithoutElasticStack
     * @dataProvider useOroPlatformEnterpriseWithoutXdebug
     * @dataProvider useOroPlatformEnterpriseWithoutBlackfire
     * @dataProvider useOroPlatformCommunity
     * @dataProvider useOroPlatformCommunityWithoutElasticStack
     * @dataProvider useOroPlatformCommunityWithoutXdebug
     * @dataProvider useOroPlatformCommunityWithoutBlackfire
     * @dataProvider useMarelloEnterprise
     * @dataProvider useMarelloEnterpriseWithoutElasticStack
     * @dataProvider useMarelloEnterpriseWithoutXdebug
     * @dataProvider useMarelloEnterpriseWithoutBlackfire
     * @dataProvider useMarelloCommunity
     * @dataProvider useMarelloCommunityWithoutElasticStack
     * @dataProvider useMarelloCommunityWithoutXdebug
     * @dataProvider useMarelloCommunityWithoutBlackfire
     * @dataProvider useMiddlewareEnterprise
     * @dataProvider useMiddlewareEnterpriseWithoutElasticStack
     * @dataProvider useMiddlewareEnterpriseWithoutXdebug
     * @dataProvider useMiddlewareEnterpriseWithoutBlackfire
     * @dataProvider useMiddlewareCommunity
     * @dataProvider useMiddlewareCommunityWithoutElasticStack
     * @dataProvider useMiddlewareCommunityWithoutXdebug
     * @dataProvider useMiddlewareCommunityWithoutBlackfire
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
     * @dataProvider useOroCommerceEnterprise
     * @dataProvider useOroCommerceEnterpriseWithoutElasticStack
     * @dataProvider useOroCommerceEnterpriseWithoutBlackfire
     * @dataProvider useOroCommerceCommunity
     * @dataProvider useOroCommerceCommunityWithoutElasticStack
     * @dataProvider useOroCommerceCommunityWithoutBlackfire
     * @dataProvider useOroCRMEnterprise
     * @dataProvider useOroCRMEnterpriseWithoutElasticStack
     * @dataProvider useOroCRMEnterpriseWithoutBlackfire
     * @dataProvider useOroCRMCommunity
     * @dataProvider useOroCRMCommunityWithoutElasticStack
     * @dataProvider useOroCRMCommunityWithoutBlackfire
     * @dataProvider useOroPlatformEnterprise
     * @dataProvider useOroPlatformEnterpriseWithoutElasticStack
     * @dataProvider useOroPlatformEnterpriseWithoutBlackfire
     * @dataProvider useOroPlatformCommunity
     * @dataProvider useOroPlatformCommunityWithoutElasticStack
     * @dataProvider useOroPlatformCommunityWithoutBlackfire
     * @dataProvider useMarelloEnterprise
     * @dataProvider useMarelloEnterpriseWithoutElasticStack
     * @dataProvider useMarelloEnterpriseWithoutBlackfire
     * @dataProvider useMarelloCommunity
     * @dataProvider useMarelloCommunityWithoutElasticStack
     * @dataProvider useMarelloCommunityWithoutBlackfire
     * @dataProvider useMiddlewareEnterprise
     * @dataProvider useMiddlewareEnterpriseWithoutElasticStack
     * @dataProvider useMiddlewareEnterpriseWithoutBlackfire
     * @dataProvider useMiddlewareCommunity
     * @dataProvider useMiddlewareCommunityWithoutElasticStack
     * @dataProvider useMiddlewareCommunityWithoutBlackfire
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
        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'sh', '/^kiboko\/php:\d+\.\d+-cli-.*-postgresql$/');
        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'fpm', '/^kiboko\/php:\d+\.\d+-fpm-.*-postgresql$/');
        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'sh-xdebug', '/^kiboko\/php:\d+\.\d+-cli-xdebug.*-postgresql$/');
        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'fpm-xdebug', '/^kiboko\/php:\d+\.\d+-fpm-xdebug.*-postgresql$/');
    }

    /**
     * @dataProvider useOroCommerceEnterpriseWithoutXdebug
     * @dataProvider useOroCommerceCommunityWithoutXdebug
     * @dataProvider useOroCRMEnterpriseWithoutXdebug
     * @dataProvider useOroCRMCommunityWithoutXdebug
     * @dataProvider useOroPlatformEnterpriseWithoutXdebug
     * @dataProvider useOroPlatformCommunityWithoutXdebug
     * @dataProvider useMarelloEnterpriseWithoutXdebug
     * @dataProvider useMarelloCommunityWithoutXdebug
     * @dataProvider useMiddlewareEnterpriseWithoutXdebug
     * @dataProvider useMiddlewareCommunityWithoutXdebug
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
     * @dataProvider useOroCommerceEnterprise
     * @dataProvider useOroCommerceEnterpriseWithoutElasticStack
     * @dataProvider useOroCommerceEnterpriseWithoutBlackfire
     * @dataProvider useOroCommerceCommunity
     * @dataProvider useOroCommerceCommunityWithoutElasticStack
     * @dataProvider useOroCommerceCommunityWithoutBlackfire
     * @dataProvider useOroCRMEnterprise
     * @dataProvider useOroCRMEnterpriseWithoutElasticStack
     * @dataProvider useOroCRMEnterpriseWithoutBlackfire
     * @dataProvider useOroCRMCommunity
     * @dataProvider useOroCRMCommunityWithoutElasticStack
     * @dataProvider useOroCRMCommunityWithoutBlackfire
     * @dataProvider useOroPlatformEnterprise
     * @dataProvider useOroPlatformEnterpriseWithoutElasticStack
     * @dataProvider useOroPlatformEnterpriseWithoutBlackfire
     * @dataProvider useOroPlatformCommunity
     * @dataProvider useOroPlatformCommunityWithoutElasticStack
     * @dataProvider useOroPlatformCommunityWithoutBlackfire
     * @dataProvider useMarelloEnterprise
     * @dataProvider useMarelloEnterpriseWithoutElasticStack
     * @dataProvider useMarelloEnterpriseWithoutBlackfire
     * @dataProvider useMarelloCommunity
     * @dataProvider useMarelloCommunityWithoutElasticStack
     * @dataProvider useMarelloCommunityWithoutBlackfire
     * @dataProvider useMiddlewareEnterprise
     * @dataProvider useMiddlewareEnterpriseWithoutElasticStack
     * @dataProvider useMiddlewareEnterpriseWithoutBlackfire
     * @dataProvider useMiddlewareCommunity
     * @dataProvider useMiddlewareCommunityWithoutElasticStack
     * @dataProvider useMiddlewareCommunityWithoutBlackfire
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

        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'sh', '/^kiboko\/php:\d+\.\d+-cli-xdebug-.*-postgresql$/');
        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'fpm', '/^kiboko\/php:\d+\.\d+-fpm-xdebug-.*-postgresql$/');
    }

    /**
     * @dataProvider useOroCommerceEnterpriseWithoutBlackfire
     * @dataProvider useOroCommerceCommunityWithoutBlackfire
     * @dataProvider useOroCRMEnterpriseWithoutBlackfire
     * @dataProvider useOroCRMCommunityWithoutBlackfire
     * @dataProvider useOroPlatformEnterpriseWithoutBlackfire
     * @dataProvider useOroPlatformCommunityWithoutBlackfire
     * @dataProvider useMarelloEnterpriseWithoutBlackfire
     * @dataProvider useMarelloCommunityWithoutBlackfire
     * @dataProvider useMiddlewareEnterpriseWithoutBlackfire
     * @dataProvider useMiddlewareCommunityWithoutBlackfire
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
     * @dataProvider useOroCommerceEnterprise
     * @dataProvider useOroCommerceEnterpriseWithoutElasticStack
     * @dataProvider useOroCommerceEnterpriseWithoutXdebug
     * @dataProvider useOroCommerceCommunity
     * @dataProvider useOroCommerceCommunityWithoutElasticStack
     * @dataProvider useOroCommerceCommunityWithoutXdebug
     * @dataProvider useOroCRMEnterprise
     * @dataProvider useOroCRMEnterpriseWithoutElasticStack
     * @dataProvider useOroCRMEnterpriseWithoutXdebug
     * @dataProvider useOroCRMCommunity
     * @dataProvider useOroCRMCommunityWithoutElasticStack
     * @dataProvider useOroCRMCommunityWithoutXdebug
     * @dataProvider useOroPlatformEnterprise
     * @dataProvider useOroPlatformEnterpriseWithoutElasticStack
     * @dataProvider useOroPlatformEnterpriseWithoutXdebug
     * @dataProvider useOroPlatformCommunity
     * @dataProvider useOroPlatformCommunityWithoutElasticStack
     * @dataProvider useOroPlatformCommunityWithoutXdebug
     * @dataProvider useMarelloEnterprise
     * @dataProvider useMarelloEnterpriseWithoutElasticStack
     * @dataProvider useMarelloEnterpriseWithoutXdebug
     * @dataProvider useMarelloCommunity
     * @dataProvider useMarelloCommunityWithoutElasticStack
     * @dataProvider useMarelloCommunityWithoutXdebug
     * @dataProvider useMiddlewareEnterprise
     * @dataProvider useMiddlewareEnterpriseWithoutElasticStack
     * @dataProvider useMiddlewareEnterpriseWithoutXdebug
     * @dataProvider useMiddlewareCommunity
     * @dataProvider useMiddlewareCommunityWithoutElasticStack
     * @dataProvider useMiddlewareCommunityWithoutXdebug
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
     * @dataProvider useOroCommerceEnterprise
     * @dataProvider useOroCommerceEnterpriseWithoutElasticStack
     * @dataProvider useOroCommerceEnterpriseWithoutXdebug
     * @dataProvider useOroCommerceEnterpriseWithoutBlackfire
     * @dataProvider useOroCommerceCommunity
     * @dataProvider useOroCommerceCommunityWithoutXdebug
     * @dataProvider useOroCommerceCommunityWithoutBlackfire
     * @dataProvider useOroCRMEnterprise
     * @dataProvider useOroCRMEnterpriseWithoutElasticStack
     * @dataProvider useOroCRMEnterpriseWithoutXdebug
     * @dataProvider useOroCRMEnterpriseWithoutBlackfire
     * @dataProvider useOroCRMCommunity
     * @dataProvider useOroCRMCommunityWithoutXdebug
     * @dataProvider useOroCRMCommunityWithoutBlackfire
     * @dataProvider useOroPlatformEnterprise
     * @dataProvider useOroPlatformEnterpriseWithoutElasticStack
     * @dataProvider useOroPlatformEnterpriseWithoutXdebug
     * @dataProvider useOroPlatformEnterpriseWithoutBlackfire
     * @dataProvider useOroPlatformCommunity
     * @dataProvider useOroPlatformCommunityWithoutXdebug
     * @dataProvider useOroPlatformCommunityWithoutBlackfire
     * @dataProvider useMarelloEnterprise
     * @dataProvider useMarelloEnterpriseWithoutElasticStack
     * @dataProvider useMarelloEnterpriseWithoutXdebug
     * @dataProvider useMarelloEnterpriseWithoutBlackfire
     * @dataProvider useMarelloCommunity
     * @dataProvider useMarelloCommunityWithoutXdebug
     * @dataProvider useMarelloCommunityWithoutBlackfire
     * @dataProvider useMiddlewareEnterprise
     * @dataProvider useMiddlewareEnterpriseWithoutElasticStack
     * @dataProvider useMiddlewareEnterpriseWithoutXdebug
     * @dataProvider useMiddlewareEnterpriseWithoutBlackfire
     * @dataProvider useMiddlewareCommunity
     * @dataProvider useMiddlewareCommunityWithoutXdebug
     * @dataProvider useMiddlewareCommunityWithoutBlackfire
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
     * @dataProvider useOroCommerceCommunityWithoutElasticStack
     * @dataProvider useOroCRMCommunityWithoutElasticStack
     * @dataProvider useOroPlatformCommunityWithoutElasticStack
     * @dataProvider useMarelloCommunityWithoutElasticStack
     * @dataProvider useMiddlewareCommunityWithoutElasticStack
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
     * @dataProvider useOroCommerceEnterprise
     * @dataProvider useOroCommerceEnterpriseWithoutXdebug
     * @dataProvider useOroCommerceEnterpriseWithoutBlackfire
     * @dataProvider useOroCommerceCommunity
     * @dataProvider useOroCommerceCommunityWithoutXdebug
     * @dataProvider useOroCommerceCommunityWithoutBlackfire
     * @dataProvider useOroCRMEnterprise
     * @dataProvider useOroCRMEnterpriseWithoutXdebug
     * @dataProvider useOroCRMEnterpriseWithoutBlackfire
     * @dataProvider useOroCRMCommunity
     * @dataProvider useOroCRMCommunityWithoutXdebug
     * @dataProvider useOroCRMCommunityWithoutBlackfire
     * @dataProvider useOroPlatformEnterprise
     * @dataProvider useOroPlatformEnterpriseWithoutXdebug
     * @dataProvider useOroPlatformEnterpriseWithoutBlackfire
     * @dataProvider useOroPlatformCommunity
     * @dataProvider useOroPlatformCommunityWithoutXdebug
     * @dataProvider useOroPlatformCommunityWithoutBlackfire
     * @dataProvider useMarelloEnterprise
     * @dataProvider useMarelloEnterpriseWithoutXdebug
     * @dataProvider useMarelloEnterpriseWithoutBlackfire
     * @dataProvider useMarelloCommunity
     * @dataProvider useMarelloCommunityWithoutXdebug
     * @dataProvider useMarelloCommunityWithoutBlackfire
     * @dataProvider useMiddlewareEnterprise
     * @dataProvider useMiddlewareEnterpriseWithoutXdebug
     * @dataProvider useMiddlewareEnterpriseWithoutBlackfire
     * @dataProvider useMiddlewareCommunity
     * @dataProvider useMiddlewareCommunityWithoutXdebug
     * @dataProvider useMiddlewareCommunityWithoutBlackfire
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
     * @dataProvider useOroCommerceEnterpriseWithoutElasticStack
     * @dataProvider useOroCommerceCommunityWithoutElasticStack
     * @dataProvider useOroCRMEnterpriseWithoutElasticStack
     * @dataProvider useOroCRMCommunityWithoutElasticStack
     * @dataProvider useOroPlatformEnterpriseWithoutElasticStack
     * @dataProvider useOroPlatformCommunityWithoutElasticStack
     * @dataProvider useMarelloEnterpriseWithoutElasticStack
     * @dataProvider useMarelloCommunityWithoutElasticStack
     * @dataProvider useMiddlewareEnterpriseWithoutElasticStack
     * @dataProvider useMiddlewareCommunityWithoutElasticStack
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
     * @dataProvider useOroCommerceEnterprise
     * @dataProvider useOroCommerceEnterpriseWithoutXdebug
     * @dataProvider useOroCommerceEnterpriseWithoutBlackfire
     * @dataProvider useOroCommerceCommunity
     * @dataProvider useOroCommerceCommunityWithoutXdebug
     * @dataProvider useOroCommerceCommunityWithoutBlackfire
     * @dataProvider useOroCRMEnterprise
     * @dataProvider useOroCRMEnterpriseWithoutXdebug
     * @dataProvider useOroCRMEnterpriseWithoutBlackfire
     * @dataProvider useOroCRMCommunity
     * @dataProvider useOroCRMCommunityWithoutXdebug
     * @dataProvider useOroCRMCommunityWithoutBlackfire
     * @dataProvider useOroPlatformEnterprise
     * @dataProvider useOroPlatformEnterpriseWithoutXdebug
     * @dataProvider useOroPlatformEnterpriseWithoutBlackfire
     * @dataProvider useOroPlatformCommunity
     * @dataProvider useOroPlatformCommunityWithoutXdebug
     * @dataProvider useOroPlatformCommunityWithoutBlackfire
     * @dataProvider useMarelloEnterprise
     * @dataProvider useMarelloEnterpriseWithoutXdebug
     * @dataProvider useMarelloEnterpriseWithoutBlackfire
     * @dataProvider useMarelloCommunity
     * @dataProvider useMarelloCommunityWithoutXdebug
     * @dataProvider useMarelloCommunityWithoutBlackfire
     * @dataProvider useMiddlewareEnterprise
     * @dataProvider useMiddlewareEnterpriseWithoutXdebug
     * @dataProvider useMiddlewareEnterpriseWithoutBlackfire
     * @dataProvider useMiddlewareCommunity
     * @dataProvider useMiddlewareCommunityWithoutXdebug
     * @dataProvider useMiddlewareCommunityWithoutBlackfire
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
     * @dataProvider useOroCommerceEnterpriseWithoutElasticStack
     * @dataProvider useOroCommerceCommunityWithoutElasticStack
     * @dataProvider useOroCRMEnterpriseWithoutElasticStack
     * @dataProvider useOroCRMCommunityWithoutElasticStack
     * @dataProvider useOroPlatformEnterpriseWithoutElasticStack
     * @dataProvider useOroPlatformCommunityWithoutElasticStack
     * @dataProvider useMarelloEnterpriseWithoutElasticStack
     * @dataProvider useMarelloCommunityWithoutElasticStack
     * @dataProvider useMiddlewareEnterpriseWithoutElasticStack
     * @dataProvider useMiddlewareCommunityWithoutElasticStack
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
