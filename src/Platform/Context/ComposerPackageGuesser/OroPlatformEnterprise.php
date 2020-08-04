<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Context\ComposerPackageGuesser;

use Kiboko\Cloud\Domain\Stack;
use Kiboko\Cloud\Platform\Context\NoPossibleGuess;
use Composer\Semver\Semver;

final class OroPlatformEnterprise implements ComposerPackageDelegatedGuesserInterface
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

    public function guess(array $package): Stack\DTO\Context
    {
        if (Semver::satisfies($package['version'], '^1.8')) {
            return new Stack\DTO\Context('5.6', 'oroplatform', '1.8', Stack\DTO\Context::DBMS_POSTGRESQL, true, true, true, true);
        }

        if (Semver::satisfies($package['version'], '^2.6')) {
            return new Stack\DTO\Context('5.6', 'oroplatform', '2.6', Stack\DTO\Context::DBMS_POSTGRESQL, true, true, true, true);
        }

        if (Semver::satisfies($package['version'], '^3.1')) {
            return new Stack\DTO\Context('7.2', 'oroplatform', '3.1', Stack\DTO\Context::DBMS_POSTGRESQL, true, true, true, true);
        }

        if (Semver::satisfies($package['version'], '^4.1')) {
            return new Stack\DTO\Context('7.4', 'oroplatform', '4.1', Stack\DTO\Context::DBMS_POSTGRESQL, true, true, true, true);
        }

        if (Semver::satisfies($package['version'], '^4.2')) {
            return new Stack\DTO\Context('7.4', 'oroplatform', '4.2', Stack\DTO\Context::DBMS_POSTGRESQL, true, true, true, true);
        }

        throw NoPossibleGuess::noVersionMatching();
    }
}