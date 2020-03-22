<?php declare(strict_types=1);

namespace Builder\Domain\Stack\OroPlatform;

use Builder\Domain\Stack\DTO;
use Builder\Domain\Stack\Resource;
use PhpCsFixer\Finder;

trait FilesAwareTrait
{
    private string $stacksPath;

    /**
     * @param DTO\Context $context
     * @param string $path
     *
     * @return \iterator|DTO\FileCommandInterface[]
     */
    private function findFilesToCopy(DTO\Context $context, string $path): DTO\FileCommandInterface
    {
        $stackPath = sprintf(
            '%s/%s/%s/%s/%s',
            $this->stacksPath,
            'orocommerce', //$context->application,
            'ee', //$context->isEnterpriseEdition ? 'ee' : 'ce',
            $context->applicationVersion,
            pathinfo($path, PATHINFO_DIRNAME)
        );
        $finder = (new Finder())
            ->in($stackPath)
            ->ignoreDotFiles(false)
            ->name(pathinfo($path, PATHINFO_BASENAME));

        foreach ($finder as $file) {
            return new DTO\CopyFile(new Resource\Local($file), $path);
        }

        throw new \RuntimeException(strtr('Source file not found %path%%fileName%.', [
            '%path%' => $stackPath,
            '%fileName%' => $path,
        ]));
    }
}