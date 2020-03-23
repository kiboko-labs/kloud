<?php declare(strict_types=1);

namespace Builder\Domain\Stack\OroPlatform;

use Builder\Domain\Stack\DTO;
use Builder\Domain\Stack\Resource;
use Composer\Semver\Semver;
use Symfony\Component\Finder\Finder;

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
        if (in_array($context->application, ['oroplatform', 'orocrm'], true)
            && Semver::satisfies($context->applicationVersion, '>=1.8 <2.0')
        ) {
            $stackPath = sprintf(
                '%s/%s/%s/%s/%s',
                $this->stacksPath,
                'oroplatform', // $context->application,
                'ce', // $context->isEnterpriseEdition ? 'ee' : 'ce',
                '1.8', // $context->applicationVersion,
                pathinfo($path, PATHINFO_DIRNAME)
            );
        } else if (in_array($context->application, ['oroplatform', 'orocrm'], true)
            && Semver::satisfies($context->applicationVersion, '>=2.0 <3.0')
        ) {
            $stackPath = sprintf(
                '%s/%s/%s/%s/%s',
                $this->stacksPath,
                'oroplatform', // $context->application,
                'ce', // $context->isEnterpriseEdition ? 'ee' : 'ce',
                '2.6', // $context->applicationVersion,
                pathinfo($path, PATHINFO_DIRNAME)
            );
        } else if (in_array($context->application, ['marello'], true)
            && Semver::satisfies($context->applicationVersion, '>=1.0 <2.0')
        ) {
            $stackPath = sprintf(
                '%s/%s/%s/%s/%s',
                $this->stacksPath,
                'oroplatform', // $context->application,
                'ce', // $context->isEnterpriseEdition ? 'ee' : 'ce',
                '1.8', // $context->applicationVersion,
                pathinfo($path, PATHINFO_DIRNAME)
            );
        } else if (in_array($context->application, ['marello'], true)
            && Semver::satisfies($context->applicationVersion, '>=2.0 <3.0')
        ) {
            $stackPath = sprintf(
                '%s/%s/%s/%s/%s',
                $this->stacksPath,
                'oroplatform', // $context->application,
                'ce', // $context->isEnterpriseEdition ? 'ee' : 'ce',
                '2.6', // $context->applicationVersion,
                pathinfo($path, PATHINFO_DIRNAME)
            );
        } else {
            $stackPath = sprintf(
                '%s/%s/%s/%s/%s',
                $this->stacksPath,
                'orocommerce', //$context->application,
                'ee', //$context->isEnterpriseEdition ? 'ee' : 'ce',
                $context->applicationVersion,
                pathinfo($path, PATHINFO_DIRNAME)
            );
        }
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