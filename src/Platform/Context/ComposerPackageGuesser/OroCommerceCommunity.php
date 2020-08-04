<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Context\ComposerPackageGuesser;

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

    public function guess(array $package): Stack\DTO\Context
    {
        if (Semver::satisfies($package['version'], '^3.1')) {
            return new Stack\DTO\Context('7.2', 'orocommerce', '3.1', Stack\DTO\Context::DBMS_POSTGRESQL, true, true, true, false);
        }

        if (Semver::satisfies($package['version'], '^4.1')) {
            return new Stack\DTO\Context('7.4', 'orocommerce', '4.1', Stack\DTO\Context::DBMS_POSTGRESQL, true, true, true, false);
        }

        if (Semver::satisfies($package['version'], '^4.2')) {
            return new Stack\DTO\Context('7.4', 'orocommerce', '4.2', Stack\DTO\Context::DBMS_POSTGRESQL, true, true, true, false);
        }

        throw NoPossibleGuess::noVersionMatching();
    }
}