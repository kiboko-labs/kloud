<?php declare(strict_types=1);

namespace Kiboko\Cloud\Platform\Context;

interface ContextGuesserInterface
{
    public function matches(array $package): bool;

    public function guess(array $package);
}