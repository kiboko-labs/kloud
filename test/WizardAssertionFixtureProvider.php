<?php declare(strict_types=1);

namespace test\Kiboko\Cloud;

use test\Kiboko\Cloud\Fixture\FixtureProviderInterface;

final class WizardAssertionFixtureProvider implements FixtureProviderInterface, \IteratorAggregate
{
    private array $phpVersions;
    private string $application;
    private array $applicationVersions;
    private bool $isEnterpriseEdition;
    private string $dbms;
    private bool $withExperimental;
    private bool $withBlackfire;
    private bool $withXdebug;
    private bool $withDejavu;
    private bool $withElasticStack;
    private bool $withDockerForMacOptimizations;
    private array $expectedMessages;
    private array $expectedImageBuildProcesses;

    public function __construct(array $phpVersions, string $application, array $applicationVersion, bool $isEnterpriseEdition, string $dbms, array $expectedMessages = [])
    {
        $this->phpVersions = $phpVersions;
        $this->application = $application;
        $this->applicationVersions = $applicationVersion;
        $this->isEnterpriseEdition = $isEnterpriseEdition;
        $this->dbms = $dbms;
        $this->withExperimental = true;
        $this->withBlackfire = true;
        $this->withXdebug = true;
        $this->withDejavu = true;
        $this->withElasticStack = true;
        $this->withDockerForMacOptimizations = true;
        $this->expectedMessages = $expectedMessages;
        $this->expectedImageBuildProcesses = [];
    }

    public function getApplication(): string
    {
        return $this->application;
    }

    public function isEnterpriseEdition(): bool
    {
        return $this->isEnterpriseEdition;
    }

    public function getDBMS(): string
    {
        return $this->dbms;
    }

    public function withExperimental(): self
    {
        $this->withExperimental = true;

        return $this;
    }

    public function withoutExperimental(): self
    {
        $this->withExperimental = false;

        return $this;
    }

    public function hasExperimental(): bool
    {
        return $this->withExperimental;
    }

    public function withBlackfire(): self
    {
        $this->withBlackfire = true;

        return $this;
    }

    public function withoutBlackfire(): self
    {
        $this->withBlackfire = false;

        return $this;
    }

    public function hasBlackfire(): bool
    {
        return $this->withBlackfire;
    }

    public function withXdebug(): self
    {
        $this->withXdebug = true;

        return $this;
    }

    public function withoutXdebug(): self
    {
        $this->withXdebug = false;

        return $this;
    }

    public function hasXdebug(): bool
    {
        return $this->withXdebug;
    }

    public function withDejavu(): self
    {
        $this->withDejavu = true;

        return $this;
    }

    public function withoutDejavu(): self
    {
        $this->withDejavu = false;

        return $this;
    }

    public function hasDejavu(): bool
    {
        return $this->withDejavu;
    }

    public function withElasticStack(): self
    {
        $this->withElasticStack = true;

        return $this;
    }

    public function withoutElasticStack(): self
    {
        $this->withElasticStack = false;

        return $this;
    }

    public function hasElasticStack(): bool
    {
        return $this->withElasticStack;
    }

    public function withDockerForMacOptimizations(): self
    {
        $this->withDockerForMacOptimizations = true;

        return $this;
    }

    public function withoutDockerForMacOptimizations(): self
    {
        $this->withDockerForMacOptimizations = false;

        return $this;
    }

    public function hasDockerForMacOptimizations(): bool
    {
        return $this->withDockerForMacOptimizations;
    }

    public function expectWizardMessages(string ...$messages): self
    {
        array_push($this->expectedMessages, ...$messages);

        return $this;
    }

    public function expectImageBuildProcesses(array ...$processes): self
    {
        array_push($this->expectedImageBuildProcesses, ...$processes);

        return $this;
    }

    public function getIterator(): \Iterator
    {
        foreach ($this->phpVersions as $phpVersion) {
            foreach ($this->applicationVersions as $applicationVersion) {
                if ($this->withExperimental === true) {
                    $experimental = [
                        '--with-experimental' => null,
                    ];
                } else {
                    $experimental = [];
                }

                yield [
                    array_merge(
                        [
                            '--php-repository' => 'kiboko-test/php',
                            '--php-version' => $phpVersion,
                            '--application' => $this->application,
                            '--application-version' => $applicationVersion,
                            $this->isEnterpriseEdition ? '--enterprise' : '--community' => null,
                            sprintf('--%s', $this->dbms) => null,
                            $this->withBlackfire ? '--with-blackfire' : '--without-blackfire' => null,
                            $this->withXdebug ? '--with-xdebug' : '--without-xdebug' => null,
                            $this->withDejavu ? '--with-dejavu' : '--without-dejavu' => null,
                            $this->withElasticStack ? '--with-elastic-stack' : '--without-elastic-stack' => null,
                            $this->withDockerForMacOptimizations ? '--with-macos-optimizations' : '--without-macos-optimizations' => null,
                        ],
                        $experimental
                    ),
                    iterator_to_array($this->generateMessages($phpVersion, $applicationVersion), false),
                    iterator_to_array($this->generateProcesses(
                        $phpVersion,
                        $applicationVersion
                    )),
                ];
            }
        }
    }

    private function generateMessages(string $phpVersion, string $applicationVersion): \Iterator
    {
        foreach ($this->expectedMessages as $message) {
            yield strtr(
                $message,
                [
                    '%phpVersion%' => $phpVersion,
                    '%application%' => $this->application,
                    '%applicationVersion%' => $applicationVersion,
                    '%applicationEdition%' => $this->isEnterpriseEdition ? 'ee' : 'ce',
                    '%dbms%' => $this->dbms,
                ]
            );
        }
    }

    private function generateProcesses(string $phpVersion, string $applicationVersion): \Iterator
    {
        foreach ($this->expectedImageBuildProcesses as $process) {
            yield new CommandExpectation($this, $process, $phpVersion, $applicationVersion);
        }
    }
}
