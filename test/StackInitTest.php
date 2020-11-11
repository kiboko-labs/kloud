<?php declare(strict_types=1);

namespace test\Kiboko\Cloud;

use Kiboko\Cloud\Platform\Console\Command;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use test\Kiboko\Cloud\Assertion\AssertTrait;
use test\Kiboko\Cloud\Fixture;
use Vfs\FileSystem;
use Vfs\Node\Directory;

final class StackInitTest extends TestCase
{
    use AssertTrait;

    private ?FileSystem $fs = null;

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

    public function useOroCommerceEnterpriseWithPostgresql()
    {
        yield from (new Fixture\OroCommerceEnterpriseFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCommerceEnterpriseWithPostgresqlWithoutElasticStack()
    {
        yield from (new Fixture\OroCommerceEnterpriseFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithoutElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCommerceEnterpriseWithPostgresqlWithoutXdebug()
    {
        yield from (new Fixture\OroCommerceEnterpriseFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithoutXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCommerceEnterpriseWithPostgresqlWithoutBlackfire()
    {
        yield from (new Fixture\OroCommerceEnterpriseFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithoutBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCommerceCommunityWithPostgresql()
    {
        yield from (new Fixture\OroCommerceCommunityFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCommerceCommunityWithPostgresqlWithoutElasticStack()
    {
        yield from (new Fixture\OroCommerceCommunityFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithoutElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCommerceCommunityWithPostgresqlWithoutXdebug()
    {
        yield from (new Fixture\OroCommerceCommunityFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithoutXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCommerceCommunityWithPostgresqlWithoutBlackfire()
    {
        yield from (new Fixture\OroCommerceCommunityFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithoutBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCRMEnterpriseWithPostgresql()
    {
        yield from (new Fixture\OroCRMEnterpriseFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCRMEnterpriseWithPostgresqlWithoutElasticStack()
    {
        yield from (new Fixture\OroCRMEnterpriseFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithoutElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCRMEnterpriseWithPostgresqlWithoutXdebug()
    {
        yield from (new Fixture\OroCRMEnterpriseFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithoutXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCRMEnterpriseWithPostgresqlWithoutBlackfire()
    {
        yield from (new Fixture\OroCRMEnterpriseFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithoutBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCRMCommunityWithPostgresql()
    {
        yield from (new Fixture\OroCRMCommunityFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCRMCommunityWithPostgresqlWithoutElasticStack()
    {
        yield from (new Fixture\OroCRMCommunityFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithoutElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCRMCommunityWithPostgresqlWithoutXdebug()
    {
        yield from (new Fixture\OroCRMCommunityFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithoutXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroCRMCommunityWithPostgresqlWithoutBlackfire()
    {
        yield from (new Fixture\OroCRMCommunityFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithoutBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroPlatformEnterpriseWithPostgresql()
    {
        yield from (new Fixture\OroPlatformEnterpriseFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroPlatformEnterpriseWithPostgresqlWithoutElasticStack()
    {
        yield from (new Fixture\OroPlatformEnterpriseFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithoutElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroPlatformEnterpriseWithPostgresqlWithoutXdebug()
    {
        yield from (new Fixture\OroPlatformEnterpriseFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithoutXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroPlatformEnterpriseWithPostgresqlWithoutBlackfire()
    {
        yield from (new Fixture\OroPlatformEnterpriseFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithoutBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroPlatformCommunityWithPostgresql()
    {
        yield from (new Fixture\OroPlatformCommunityFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroPlatformCommunityWithPostgresqlWithoutElasticStack()
    {
        yield from (new Fixture\OroPlatformCommunityFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithoutElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroPlatformCommunityWithPostgresqlWithoutXdebug()
    {
        yield from (new Fixture\OroPlatformCommunityFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithoutXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useOroPlatformCommunityWithPostgresqlWithoutBlackfire()
    {
        yield from (new Fixture\OroPlatformCommunityFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithoutBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMarelloEnterpriseWithPostgresql()
    {
        yield from (new Fixture\MarelloEnterpriseFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMarelloEnterpriseWithPostgresqlWithoutElasticStack()
    {
        yield from (new Fixture\MarelloEnterpriseFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithoutElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMarelloEnterpriseWithPostgresqlWithoutXdebug()
    {
        yield from (new Fixture\MarelloEnterpriseFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithoutXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMarelloEnterpriseWithPostgresqlWithoutBlackfire()
    {
        yield from (new Fixture\MarelloEnterpriseFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithoutBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMarelloCommunityWithPostgresql()
    {
        yield from (new Fixture\MarelloCommunityFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMarelloCommunityWithPostgresqlWithoutElasticStack()
    {
        yield from (new Fixture\MarelloCommunityFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithoutElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMarelloCommunityWithPostgresqlWithoutXdebug()
    {
        yield from (new Fixture\MarelloCommunityFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithoutXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMarelloCommunityWithPostgresqlWithoutBlackfire()
    {
        yield from (new Fixture\MarelloCommunityFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithoutBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMiddlewareEnterpriseWithPostgresql()
    {
        yield from (new Fixture\MiddlewareEnterpriseFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMiddlewareEnterpriseWithPostgresqlWithoutElasticStack()
    {
        yield from (new Fixture\MiddlewareEnterpriseFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithoutElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMiddlewareEnterpriseWithPostgresqlWithoutXdebug()
    {
        yield from (new Fixture\MiddlewareEnterpriseFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithoutXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMiddlewareEnterpriseWithPostgresqlWithoutBlackfire()
    {
        yield from (new Fixture\MiddlewareEnterpriseFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithoutBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMiddlewareCommunityWithPostgresql()
    {
        yield from (new Fixture\MiddlewareCommunityFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMiddlewareCommunityWithPostgresqlWithoutElasticStack()
    {
        yield from (new Fixture\MiddlewareCommunityFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithoutElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMiddlewareCommunityWithPostgresqlWithoutXdebug()
    {
        yield from (new Fixture\MiddlewareCommunityFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithBlackfire(),
                new Fixture\Visitor\WithoutXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    public function useMiddlewareCommunityWithPostgresqlWithoutBlackfire()
    {
        yield from (new Fixture\MiddlewareCommunityFixture('postgresql'))
            ->apply(
                new Fixture\Visitor\WithoutBlackfire(),
                new Fixture\Visitor\WithXdebug(),
                new Fixture\Visitor\WithDejavu(),
                new Fixture\Visitor\WithElasticStack(),
                new Fixture\Visitor\WithDockerForMacOptimizations(),
            );
    }

    /**
     * @dataProvider useOroCommerceEnterpriseWithPostgresql
     * @dataProvider useOroCommerceEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCommerceEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useOroCommerceEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useOroCommerceCommunityWithPostgresql
     * @dataProvider useOroCommerceCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCommerceCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useOroCommerceCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useOroCRMEnterpriseWithPostgresql
     * @dataProvider useOroCRMEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCRMEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useOroCRMEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useOroCRMCommunityWithPostgresql
     * @dataProvider useOroCRMCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCRMCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useOroCRMCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useOroPlatformEnterpriseWithPostgresql
     * @dataProvider useOroPlatformEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroPlatformEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useOroPlatformEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useOroPlatformCommunityWithPostgresql
     * @dataProvider useOroPlatformCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useOroPlatformCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useOroPlatformCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useMarelloEnterpriseWithPostgresql
     * @dataProvider useMarelloEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useMarelloEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useMarelloEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useMarelloCommunityWithPostgresql
     * @dataProvider useMarelloCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useMarelloCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useMarelloCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useMiddlewareEnterpriseWithPostgresql
     * @dataProvider useMiddlewareEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useMiddlewareEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useMiddlewareEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useMiddlewareCommunityWithPostgresql
     * @dataProvider useMiddlewareCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useMiddlewareCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useMiddlewareCommunityWithPostgresqlWithoutBlackfire
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
     * @dataProvider useOroCommerceEnterpriseWithPostgresql
     * @dataProvider useOroCommerceEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCommerceEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useOroCommerceCommunityWithPostgresql
     * @dataProvider useOroCommerceCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCommerceCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useOroCRMEnterpriseWithPostgresql
     * @dataProvider useOroCRMEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCRMEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useOroCRMCommunityWithPostgresql
     * @dataProvider useOroCRMCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCRMCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useOroPlatformEnterpriseWithPostgresql
     * @dataProvider useOroPlatformEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroPlatformEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useOroPlatformCommunityWithPostgresql
     * @dataProvider useOroPlatformCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useOroPlatformCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useMarelloEnterpriseWithPostgresql
     * @dataProvider useMarelloEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useMarelloEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useMarelloCommunityWithPostgresql
     * @dataProvider useMarelloCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useMarelloCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useMiddlewareEnterpriseWithPostgresql
     * @dataProvider useMiddlewareEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useMiddlewareEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useMiddlewareCommunityWithPostgresql
     * @dataProvider useMiddlewareCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useMiddlewareCommunityWithPostgresqlWithoutBlackfire
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
        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'sh', '/-postgresql$/');
        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'fpm', '/-postgresql$/');
        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'sh-xdebug', '/-postgresql$/');
        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'fpm-xdebug', '/-postgresql$/');
    }

    /**
     * @dataProvider useOroCommerceEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useOroCommerceCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useOroCRMEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useOroCRMCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useOroPlatformEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useOroPlatformCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useMarelloEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useMarelloCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useMiddlewareEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useMiddlewareCommunityWithPostgresqlWithoutXdebug
     */
    public function testSuccessfulWizardHavingPostgreNotHavingXdebug($inputOptions, array $desiredOutputs)
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
        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'sh', '/-postgresql$/');
        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'fpm', '/-postgresql$/');
    }

    /**
     * @dataProvider useOroCommerceEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useOroCommerceCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useOroCRMEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useOroCRMCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useOroPlatformEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useOroPlatformCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useMarelloEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useMarelloCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useMiddlewareEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useMiddlewareCommunityWithPostgresqlWithoutBlackfire
     */
    public function testSuccessfulWizardHavingPostgreNotHavingBlackfire($inputOptions, array $desiredOutputs)
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

        $this->assertDockerServiceNotUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'sh', '/-blackfire-/');
        $this->assertDockerServiceNotUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'fpm', '/-blackfire-/');
    }

    /**
     * @dataProvider useOroCommerceEnterpriseWithPostgresql
     * @dataProvider useOroCommerceEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCommerceEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useOroCommerceCommunityWithPostgresql
     * @dataProvider useOroCommerceCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCommerceCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useOroCRMEnterpriseWithPostgresql
     * @dataProvider useOroCRMEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCRMEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useOroCRMCommunityWithPostgresql
     * @dataProvider useOroCRMCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCRMCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useOroPlatformEnterpriseWithPostgresql
     * @dataProvider useOroPlatformEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroPlatformEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useOroPlatformCommunityWithPostgresql
     * @dataProvider useOroPlatformCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useOroPlatformCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useMarelloEnterpriseWithPostgresql
     * @dataProvider useMarelloEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useMarelloEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useMarelloCommunityWithPostgresql
     * @dataProvider useMarelloCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useMarelloCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useMiddlewareEnterpriseWithPostgresql
     * @dataProvider useMiddlewareEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useMiddlewareEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useMiddlewareCommunityWithPostgresql
     * @dataProvider useMiddlewareCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useMiddlewareCommunityWithPostgresqlWithoutXdebug
     */
    public function testSuccessfulWizardHavingPostgreHavingBlackfire($inputOptions, array $desiredOutputs)
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

        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'sh', '/-blackfire-/');
        $this->assertDockerServiceUsesImagePattern(sprintf('%s://test/docker-compose.yml', $this->fs->getScheme()), 'fpm', '/-blackfire-/');
    }

    /**
     * @dataProvider useOroCommerceEnterpriseWithPostgresql
     * @dataProvider useOroCommerceEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCommerceEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useOroCommerceEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useOroCommerceCommunityWithPostgresql
     * @dataProvider useOroCommerceCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useOroCommerceCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useOroCRMEnterpriseWithPostgresql
     * @dataProvider useOroCRMEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCRMEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useOroCRMEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useOroCRMCommunityWithPostgresql
     * @dataProvider useOroCRMCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useOroCRMCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useOroPlatformEnterpriseWithPostgresql
     * @dataProvider useOroPlatformEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroPlatformEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useOroPlatformEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useOroPlatformCommunityWithPostgresql
     * @dataProvider useOroPlatformCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useOroPlatformCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useMarelloEnterpriseWithPostgresql
     * @dataProvider useMarelloEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useMarelloEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useMarelloEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useMarelloCommunityWithPostgresql
     * @dataProvider useMarelloCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useMarelloCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useMiddlewareEnterpriseWithPostgresql
     * @dataProvider useMiddlewareEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useMiddlewareEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useMiddlewareEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useMiddlewareCommunityWithPostgresql
     * @dataProvider useMiddlewareCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useMiddlewareCommunityWithPostgresqlWithoutBlackfire
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
     * @dataProvider useOroCommerceCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCRMCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useOroPlatformCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useMarelloCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useMiddlewareCommunityWithPostgresqlWithoutElasticStack
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
     * @dataProvider useOroCommerceEnterpriseWithPostgresql
     * @dataProvider useOroCommerceEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useOroCommerceEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useOroCommerceCommunityWithPostgresql
     * @dataProvider useOroCommerceCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useOroCommerceCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useOroCRMEnterpriseWithPostgresql
     * @dataProvider useOroCRMEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useOroCRMEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useOroCRMCommunityWithPostgresql
     * @dataProvider useOroCRMCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useOroCRMCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useOroPlatformEnterpriseWithPostgresql
     * @dataProvider useOroPlatformEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useOroPlatformEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useOroPlatformCommunityWithPostgresql
     * @dataProvider useOroPlatformCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useOroPlatformCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useMarelloEnterpriseWithPostgresql
     * @dataProvider useMarelloEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useMarelloEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useMarelloCommunityWithPostgresql
     * @dataProvider useMarelloCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useMarelloCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useMiddlewareEnterpriseWithPostgresql
     * @dataProvider useMiddlewareEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useMiddlewareEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useMiddlewareCommunityWithPostgresql
     * @dataProvider useMiddlewareCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useMiddlewareCommunityWithPostgresqlWithoutBlackfire
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
     * @dataProvider useOroCommerceEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCommerceCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCRMEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCRMCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useOroPlatformEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroPlatformCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useMarelloEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useMarelloCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useMiddlewareEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useMiddlewareCommunityWithPostgresqlWithoutElasticStack
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
     * @dataProvider useOroCommerceEnterpriseWithPostgresql
     * @dataProvider useOroCommerceEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useOroCommerceEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useOroCommerceCommunityWithPostgresql
     * @dataProvider useOroCommerceCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useOroCommerceCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useOroCRMEnterpriseWithPostgresql
     * @dataProvider useOroCRMEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useOroCRMEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useOroCRMCommunityWithPostgresql
     * @dataProvider useOroCRMCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useOroCRMCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useOroPlatformEnterpriseWithPostgresql
     * @dataProvider useOroPlatformEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useOroPlatformEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useOroPlatformCommunityWithPostgresql
     * @dataProvider useOroPlatformCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useOroPlatformCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useMarelloEnterpriseWithPostgresql
     * @dataProvider useMarelloEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useMarelloEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useMarelloCommunityWithPostgresql
     * @dataProvider useMarelloCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useMarelloCommunityWithPostgresqlWithoutBlackfire
     * @dataProvider useMiddlewareEnterpriseWithPostgresql
     * @dataProvider useMiddlewareEnterpriseWithPostgresqlWithoutXdebug
     * @dataProvider useMiddlewareEnterpriseWithPostgresqlWithoutBlackfire
     * @dataProvider useMiddlewareCommunityWithPostgresql
     * @dataProvider useMiddlewareCommunityWithPostgresqlWithoutXdebug
     * @dataProvider useMiddlewareCommunityWithPostgresqlWithoutBlackfire
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
     * @dataProvider useOroCommerceEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCommerceCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCRMEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCRMCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useOroPlatformEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroPlatformCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useMarelloEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useMarelloCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useMiddlewareEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useMiddlewareCommunityWithPostgresqlWithoutElasticStack
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
