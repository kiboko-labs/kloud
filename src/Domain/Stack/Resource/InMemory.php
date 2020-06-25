<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\Resource;

final class InMemory implements FileInterface
{
    private string $path;
    private string $content;

    public function __construct(string $path, string $content)
    {
        $this->path = $path;
        $this->content = $content;
    }

    public function asResource()
    {
        $stream = fopen('php://temp', 'w+');
        fwrite($stream, $this->content);
        fseek($stream, 0, SEEK_SET);

        return $stream;
    }

    public function asBlob(): string
    {
        return $this->content;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getDirectory(): string
    {
        return dirname($this->path);
    }
}