<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Platform\Edition;

class Edition implements EditionInterface
{
    public string $package;
    public string $version;
    public string $edition;

    public function __construct(string $package, string $version, string $edition)
    {
        $this->package = $package;
        $this->version = $version;
        $this->edition = $edition;
    }
}