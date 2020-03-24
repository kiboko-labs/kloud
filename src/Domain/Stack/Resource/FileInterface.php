<?php declare(strict_types=1);

namespace Builder\Domain\Stack\Resource;

interface FileInterface
{
    /**
     * @return resource
     */
    public function asResource();
}