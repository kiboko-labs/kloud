<?php declare(strict_types=1);

namespace Builder\Assert;

interface AssertionInterface
{
    public function __toString();
    public function __invoke(): bool;
}