<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\Resource;

final class InMemory implements FileInterface
{
    private string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function asResource()
    {
        $stream = fopen('php://temp', 'w+');
        fwrite($stream, $this->content);
        fseek($stream, 0, SEEK_SET);

        return $stream;
    }
}