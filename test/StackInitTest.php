<?php declare(strict_types=1);

namespace test\Kiboko\Cloud;

use Kiboko\Cloud\Platform\Console\Command;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Vfs\FileSystem;
use Vfs\Node\Directory;

final class StackInitTest extends TestCase
{
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
        yield from (new WizardAssertionManager(['5.6'], 'orocommerce', ['1.6'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCommerce Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.1', '7.2'], 'orocommerce', ['3.1'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCommerce Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.3'], 'orocommerce', ['3.1', '4.1'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCommerce Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.4'], 'orocommerce', ['4.1'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCommerce Enterprise Edition, version %applicationVersion%.',
            )
        ;
    }

    public function useOroCommerceEnterpriseWithPostgresqlWithoutElasticStack()
    {
        yield from (new WizardAssertionManager(['5.6'], 'orocommerce', ['1.6'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCommerce Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.1', '7.2'], 'orocommerce', ['3.1'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCommerce Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.3'], 'orocommerce', ['3.1', '4.1'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCommerce Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.4'], 'orocommerce', ['4.1'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCommerce Enterprise Edition, version %applicationVersion%.',
            )
        ;
    }

    public function useOroCommerceCommunityWithPostgresql()
    {
        yield from (new WizardAssertionManager(['5.6'], 'orocommerce', ['1.6'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCommerce Community Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.1', '7.2'], 'orocommerce', ['3.1'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCommerce Community Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.3'], 'orocommerce', ['3.1', '4.1'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCommerce Community Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.4'], 'orocommerce', ['4.1'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCommerce Community Edition, version %applicationVersion%.',
            )
        ;
    }

    public function useOroCommerceCommunityWithPostgresqlWithoutElasticStack()
    {
        yield from (new WizardAssertionManager(['5.6'], 'orocommerce', ['1.6'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCommerce Community Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.1', '7.2'], 'orocommerce', ['3.1'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCommerce Community Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.3'], 'orocommerce', ['3.1', '4.1'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCommerce Community Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.4'], 'orocommerce', ['4.1'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCommerce Community Edition, version %applicationVersion%.',
            )
        ;
    }

    public function useOroCRMEnterpriseWithPostgresql()
    {
        yield from (new WizardAssertionManager(['5.6'], 'orocrm', ['1.8', '2.6'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCRM Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.1', '7.2', '7.3'], 'orocrm', ['3.1'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCRM Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.3', '7.4'], 'orocrm', ['4.1'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCRM Enterprise Edition, version %applicationVersion%.',
            )
        ;
    }

    public function useOroCRMEnterpriseWithPostgresqlWithoutElasticStack()
    {
        yield from (new WizardAssertionManager(['5.6'], 'orocrm', ['1.8', '2.6'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCRM Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.1', '7.2', '7.3'], 'orocrm', ['3.1'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCRM Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.3', '7.4'], 'orocrm', ['4.1'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCRM Enterprise Edition, version %applicationVersion%.',
            )
        ;
    }

    public function useOroCRMCommunityWithPostgresql()
    {
        yield from (new WizardAssertionManager(['5.6'], 'orocrm', ['1.8', '2.6'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCRM Community Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.1', '7.2', '7.3'], 'orocrm', ['3.1'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCRM Community Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.3', '7.4'], 'orocrm', ['4.1'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCRM Community Edition, version %applicationVersion%.',
            )
        ;
    }

    public function useOroCRMCommunityWithPostgresqlWithoutElasticStack()
    {
        yield from (new WizardAssertionManager(['5.6'], 'orocrm', ['1.8', '2.6'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCRM Community Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.1', '7.2', '7.3'], 'orocrm', ['3.1'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCRM Community Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.3', '7.4'], 'orocrm', ['4.1'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroCRM Community Edition, version %applicationVersion%.',
            )
        ;
    }

    public function useOroPlatformEnterpriseWithPostgresql()
    {
        yield from (new WizardAssertionManager(['5.6'], 'oroplatform', ['1.8', '2.6'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroPlatform Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.1', '7.2', '7.3'], 'oroplatform', ['3.1'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroPlatform Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.3', '7.4'], 'oroplatform', ['4.1'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroPlatform Enterprise Edition, version %applicationVersion%.',
            )
        ;
    }

    public function useOroPlatformEnterpriseWithPostgresqlWithoutElasticStack()
    {
        yield from (new WizardAssertionManager(['5.6'], 'oroplatform', ['1.8', '2.6'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroPlatform Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.1', '7.2', '7.3'], 'oroplatform', ['3.1'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroPlatform Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.3', '7.4'], 'oroplatform', ['4.1'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroPlatform Enterprise Edition, version %applicationVersion%.',
            )
        ;
    }

    public function useOroPlatformCommunityWithPostgresql()
    {
        yield from (new WizardAssertionManager(['5.6'], 'oroplatform', ['1.8', '2.6'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroPlatform Community Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.1', '7.2', '7.3'], 'oroplatform', ['3.1'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroPlatform Community Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.3', '7.4'], 'oroplatform', ['4.1'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroPlatform Community Edition, version %applicationVersion%.',
            )
        ;
    }

    public function useOroPlatformCommunityWithPostgresqlWithoutElasticStack()
    {
        yield from (new WizardAssertionManager(['5.6'], 'oroplatform', ['1.8', '2.6'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroPlatform Community Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.1', '7.2', '7.3'], 'oroplatform', ['3.1'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroPlatform Community Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.3', '7.4'], 'oroplatform', ['4.1'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing OroPlatform Community Edition, version %applicationVersion%.',
            )
        ;
    }

    public function useMarelloEnterpriseWithPostgresql()
    {
        yield from (new WizardAssertionManager(['5.6'], 'marello', ['1.5', '1.6'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing Marello Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.1', '7.2'], 'marello', ['1.5', '1.6', '2.0', '2.1', '2.2'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing Marello Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.3'], 'marello', ['2.0', '2.1', '2.2', '3.0'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing Marello Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.4'], 'marello', ['3.0'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing Marello Enterprise Edition, version %applicationVersion%.',
            )
        ;
    }

    public function useMarelloEnterpriseWithPostgresqlWithoutElasticStack()
    {
        yield from (new WizardAssertionManager(['5.6'], 'marello', ['1.5', '1.6'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing Marello Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.1', '7.2'], 'marello', ['1.5', '1.6', '2.0', '2.1', '2.2'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing Marello Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.3'], 'marello', ['2.0', '2.1', '2.2', '3.0'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing Marello Enterprise Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.4'], 'marello', ['3.0'], true, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing Marello Enterprise Edition, version %applicationVersion%.',
            )
        ;
    }

    public function useMarelloCommunityWithPostgresql()
    {
        yield from (new WizardAssertionManager(['5.6'], 'marello', ['1.5', '1.6'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing Marello Community Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.1', '7.2'], 'marello', ['1.5', '1.6', '2.0', '2.1', '2.2'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing Marello Community Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.3'], 'marello', ['2.0', '2.1', '2.2', '3.0'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing Marello Community Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.4'], 'marello', ['3.0'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing Marello Community Edition, version %applicationVersion%.',
            )
        ;
    }

    public function useMarelloCommunityWithPostgresqlWithoutElasticStack()
    {
        yield from (new WizardAssertionManager(['5.6'], 'marello', ['1.5', '1.6'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing Marello Community Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.1', '7.2'], 'marello', ['1.5', '1.6', '2.0', '2.1', '2.2'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing Marello Community Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.3'], 'marello', ['2.0', '2.1', '2.2', '3.0'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing Marello Community Edition, version %applicationVersion%.',
            )
        ;
        yield from (new WizardAssertionManager(['7.4'], 'marello', ['3.0'], false, 'postgresql'))
            ->withBlackfire()
            ->withXdebug()
            ->withDejavu()
            ->withoutElasticStack()
            ->withDockerForMacOptimizations()
            ->expectMessages(
                'Choosing Marello Community Edition, version %applicationVersion%.',
            )
        ;
    }

    /**
     * @dataProvider useOroCommerceEnterpriseWithPostgresql
     * @dataProvider useOroCommerceEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCommerceCommunityWithPostgresql
     * @dataProvider useOroCommerceCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCRMEnterpriseWithPostgresql
     * @dataProvider useOroCRMEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCRMCommunityWithPostgresql
     * @dataProvider useOroCRMCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useOroPlatformEnterpriseWithPostgresql
     * @dataProvider useOroPlatformEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroPlatformCommunityWithPostgresql
     * @dataProvider useOroPlatformCommunityWithPostgresqlWithoutElasticStack
     * @dataProvider useMarelloEnterpriseWithPostgresql
     * @dataProvider useMarelloEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useMarelloCommunityWithPostgresql
     * @dataProvider useMarelloCommunityWithPostgresqlWithoutElasticStack
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
     * @dataProvider useOroCommerceCommunityWithPostgresql
     * @dataProvider useOroCRMEnterpriseWithPostgresql
     * @dataProvider useOroCRMEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroCRMCommunityWithPostgresql
     * @dataProvider useOroPlatformEnterpriseWithPostgresql
     * @dataProvider useOroPlatformEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useOroPlatformCommunityWithPostgresql
     * @dataProvider useMarelloEnterpriseWithPostgresql
     * @dataProvider useMarelloEnterpriseWithPostgresqlWithoutElasticStack
     * @dataProvider useMarelloCommunityWithPostgresql
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
     * @dataProvider useOroCommerceCommunityWithPostgresql
     * @dataProvider useOroCRMEnterpriseWithPostgresql
     * @dataProvider useOroCRMCommunityWithPostgresql
     * @dataProvider useOroPlatformEnterpriseWithPostgresql
     * @dataProvider useOroPlatformCommunityWithPostgresql
     * @dataProvider useMarelloEnterpriseWithPostgresql
     * @dataProvider useMarelloCommunityWithPostgresql
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
     * @dataProvider useOroCommerceCommunityWithPostgresql
     * @dataProvider useOroCRMEnterpriseWithPostgresql
     * @dataProvider useOroCRMCommunityWithPostgresql
     * @dataProvider useOroPlatformEnterpriseWithPostgresql
     * @dataProvider useOroPlatformCommunityWithPostgresql
     * @dataProvider useMarelloEnterpriseWithPostgresql
     * @dataProvider useMarelloCommunityWithPostgresql
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
