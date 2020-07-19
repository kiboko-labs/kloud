<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\DTO;

final class Context
{
    const DBMS_POSTGRESQL = 'postgresql';
    const DBMS_MYSQL = 'mysql';

    public string $phpVersion;
    public ?bool $withBlackfire;
    public ?bool $withXdebug;
    public ?string $dbms;
    public ?string $application;
    public ?string $applicationVersion;
    public ?bool $isEnterpriseEdition;

    public function __construct(
        string $phpVersion,
        ?string $application = null,
        ?string $applicationVersion = null,
        ?string $dbms = self::DBMS_POSTGRESQL,
        ?bool $withBlackfire = null,
        ?bool $withXdebug = null,
        ?bool $isEnterpriseEdition = false
    ) {
        $this->phpVersion = $phpVersion;
        $this->withBlackfire = $withBlackfire;
        $this->withXdebug = $withXdebug;
        $this->dbms = $dbms;
        $this->application = $application;
        $this->applicationVersion = $applicationVersion;
        $this->isEnterpriseEdition = $isEnterpriseEdition;
    }

    public function getImagesRegex(): string
    {
        if ($this->withBlackfire && $this->withXdebug) {
            $variations = '(?:|-blackfire|-xdebug)';
        } elseif ($this->withBlackfire && !$this->withXdebug) {
            $variations = '(?:|-blackfire)';
        } elseif (!$this->withBlackfire && $this->withXdebug) {
            $variations = '(?:|-xdebug)';
        } else {
            $variations = '';
        }

        if (empty($this->application) || empty($this->applicationVersion)) {
            if (empty($this->dbms)) {
                return sprintf(
                    '/^%s-(?:cli|fpm)%s$/',
                    preg_quote($this->phpVersion),
                    $variations
                );
            }

            return sprintf(
                '/^%s-(?:cli|fpm)%s-%s$/',
                preg_quote($this->phpVersion),
                $variations,
                $this->dbms
            );
        }

        return sprintf(
            '/^%s-(?:cli|fpm)%s-%s-%s-%s-%s$/',
            preg_quote($this->phpVersion),
            $variations,
            $this->application,
            $this->isEnterpriseEdition ? 'ee' : 'ce',
            preg_quote($this->applicationVersion),
            $this->dbms
        );
    }
}