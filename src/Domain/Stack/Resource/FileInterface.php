<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\Resource;

interface FileInterface
{
    /**
     * @return resource
     */
    public function asResource();
}