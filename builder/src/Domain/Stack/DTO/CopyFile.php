<?php declare(strict_types=1);

namespace Builder\Domain\Stack\DTO;

use Builder\Domain\Stack\Resource\FileInterface;

final class CopyFile implements FileCommandInterface
{
    private FileInterface $file;
    private string $destinationPath;

    public function __construct(FileInterface $file, string $destinationPath)
    {
        $this->file = $file;
        $this->destinationPath = $destinationPath;
    }

    public function saveTo(string $path): void
    {
        $directory = dirname($path . $this->destinationPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $stream = fopen($path . $this->destinationPath, 'w');

        stream_copy_to_stream($this->file->asResource(), $stream);
        fclose($stream);
    }
}