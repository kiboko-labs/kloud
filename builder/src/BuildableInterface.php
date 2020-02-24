<?php declare(strict_types=1);

namespace Builder;

use Builder\Command\CommandInterface;

/**
 * @property-read string $path
 */
interface BuildableInterface
{
    public function build(): CommandInterface;
}