<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack;

use Kiboko\Cloud\Domain\Stack\DTO;

interface StackBuilderInterface
{
    public function build(DTO\Context $context): DTO\Stack;
}