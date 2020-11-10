<?php declare(strict_types=1);

namespace test\Kiboko\Cloud;

final class WizardAssertionManager implements \IteratorAggregate
{
    private array $phpVersions;
    private string $application;
    private array $applicationVersion;
    private bool $isEnterpriseEdition;
    private string $dbms;
    private bool $withBlackfire;
    private bool $withXdebug;
    private bool $withDejavu;
    private bool $withElasticStack;
    private bool $withDockerForMacOptimizations;
    private array $expectedMessages;

    public function __construct(array $phpVersions, string $application, array $applicationVersion, bool $isEnterpriseEdition, string $dbms, array $expectedMessages = [])
    {
        $this->phpVersions = $phpVersions;
        $this->application = $application;
        $this->applicationVersion = $applicationVersion;
        $this->isEnterpriseEdition = $isEnterpriseEdition;
        $this->dbms = $dbms;
        $this->withBlackfire = false;
        $this->withXdebug = false;
        $this->withDejavu = false;
        $this->withElasticStack = false;
        $this->withDockerForMacOptimizations = false;
        $this->expectedMessages = [];
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

    public function expectMessages(string ...$messages): self
    {
        array_push($this->expectedMessages, ...$messages);

        return $this;
    }

    public function getIterator(): \Iterator
    {
        foreach ($this->phpVersions as $phpVersion) {
            foreach ($this->applicationVersion as $applicationVersion) {
                yield [
                    [
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
                    iterator_to_array($this->generateMessages($phpVersion, $applicationVersion), false)
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
                ]
            );
        }
    }
}
