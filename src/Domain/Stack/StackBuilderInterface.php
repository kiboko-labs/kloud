<?php declare(strict_types=1);

namespace Builder\Domain\Stack;

use Builder\Domain\Stack\DTO;

interface StackBuilderInterface
{
    public function build(DTO\Context $context): DTO\Stack;
}