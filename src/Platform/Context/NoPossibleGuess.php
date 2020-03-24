<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Context;

final class NoPossibleGuess extends \RuntimeException
{
    public static function noVersionMatching()
    {
        return new self('No gessable version matching for a new application context.');
    }

    public static function packageIsNotMatchingAnyApplicationContext()
    {
        return new self('No gessable package matching for a new application context.');
    }
}