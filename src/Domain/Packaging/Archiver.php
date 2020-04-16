<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging;

use splitbrain\PHPArchive\Archive;
use splitbrain\PHPArchive\FileInfo;
use splitbrain\PHPArchive\Tar;

final class Archiver
{
    private Archive $archive;

    public function __construct()
    {
        $this->archive = new Tar();
        $this->archive->create();
        $this->archive->setCompression(0, Archive::COMPRESS_GZIP);
    }

    public function addPath(string $path)
    {
        $iterator = new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::KEY_AS_PATHNAME | \RecursiveDirectoryIterator::CURRENT_AS_FILEINFO);
        $iterator = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::LEAVES_ONLY);
        $iterator = new \CallbackFilterIterator($iterator, function (\SplFileInfo $file) {
            return $file->isFile() && $file->isReadable();
        });

        /** @var \SplFileInfo|\PharFileInfo $file */
        foreach ($iterator as $file) {
            $relativePath = preg_replace('/^'.preg_quote($path, '/').'/', '', $file->getPathname());
            $this->archive->addFile($path . '/' . $relativePath, $this->mutateFileInfo($relativePath, $file));
        }
    }

    public function mutateFileInfo(string $path, \SplFileInfo $info): FileInfo
    {
        $file = new FileInfo($path);
        $file->setMode($info->getPerms());
        $file->setUid($info->getOwner());
        $file->setGid($info->getGroup());
        $file->setSize($info->getSize());
        $file->setIsdir($info->isDir());
        $file->setMtime($info->getMTime());

        return $file;
    }

    public function __toString()
    {
        return $this->archive->getArchive();
    }
}