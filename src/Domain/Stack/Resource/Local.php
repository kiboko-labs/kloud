<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\Resource;

final class Local implements FileInterface
{
    private \SplFileInfo $file;

    public function __construct(\SplFileInfo $file)
    {
        $this->file = $file;
    }

    public function asResource()
    {
        return fopen($this->file->getPathname(), 'r');
    }
}