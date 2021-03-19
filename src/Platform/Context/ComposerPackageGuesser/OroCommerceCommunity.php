<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Context\ComposerPackageGuesser;

use Kiboko\Cloud\Domain\Packaging\RepositoryInterface;
use Kiboko\Cloud\Domain\Stack;
use Kiboko\Cloud\Platform\Context\NoPossibleGuess;
use Composer\Semver\Semver;

final class OroCommerceCommunity implements ComposerPackageDelegatedGuesserInterface
{
    private string $packageName;

    public function __construct(string $packageName)
    {
        $this->packageName = $packageName;
    }

    public function matches(array $package): bool
    {
        return $package['name'] === $this->packageName;
    }

    public function guess(RepositoryInterface $repository, array $package): Stack\DTO\Context
    {
        if (Semver::satisfies($package['version'], '^3.1')) {
            return (new Stack\ContextBuilder($repository, '7.2'))
                ->setApplication('orocommerce', '3.1', false)
                ->setDbms(Stack\DTO\Context::DBMS_POSTGRESQL)
                ->getContext();
        }

        if (Semver::satisfies($package['version'], '4.1.*')) {
            return (new Stack\ContextBuilder($repository, '7.4'))
                ->setApplication('orocommerce', '4.1', false)
                ->setDbms(Stack\DTO\Context::DBMS_POSTGRESQL)
                ->getContext();
        }

        if (Semver::satisfies($package['version'], '^4.2.0')) {
            return (new Stack\ContextBuilder($repository, '7.4'))
                ->setApplication('orocommerce', '4.2', false)
                ->setDbms(Stack\DTO\Context::DBMS_POSTGRESQL)
                ->getContext();
        }

        throw NoPossibleGuess::noVersionMatching();
    }
}
