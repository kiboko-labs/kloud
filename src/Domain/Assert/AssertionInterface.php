<?php

declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Assert;

interface AssertionInterface
{
    public function __invoke(): Result\AssertionResultInterface;
}
