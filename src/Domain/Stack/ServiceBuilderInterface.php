<?php declare(strict_types=1);

namespace Builder\Domain\Stack;

use Builder\Domain\Stack\DTO;
use Builder\Domain\Stack\DTO\Context;

interface ServiceBuilderInterface
{
    public function matches(Context $context): bool;
    public function build(DTO\Stack $stack, DTO\Context $context): DTO\Stack;
}