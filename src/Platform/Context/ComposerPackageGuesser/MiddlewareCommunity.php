<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Context\ComposerPackageGuesser;

use Kiboko\Cloud\Domain\Stack;
use Kiboko\Cloud\Platform\Context\NoPossibleGuess;
use Composer\Semver\Semver;

final class MiddlewareCommunity implements ComposerPackageDelegatedGuesserInterface
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
        if (Semver::satisfies($package['version'], '^1.0')) {
            return (new Stack\ContextBuilder('7.2'))
                ->setApplication('middleware', '1.0', false)
                ->setDbms(Stack\DTO\Context::DBMS_POSTGRESQL)
                ->getContext();
        }

        throw NoPossibleGuess::noVersionMatching();
    }
}