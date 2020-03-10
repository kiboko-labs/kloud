<?php

declare(strict_types=1);

namespace Builder\Domain\Assert;

interface AssertionInterface
{
    public function __invoke(): Result\AssertionResultInterface;
}
