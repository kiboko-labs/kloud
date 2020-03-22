<?php declare(strict_types=1);

namespace Builder\Domain\Stack;

use Builder\Domain\Stack\DTO\Context;

interface DelegatedStackBuilderInterface extends StackBuilderInterface
{
    public function matches(Context $context): bool;
}