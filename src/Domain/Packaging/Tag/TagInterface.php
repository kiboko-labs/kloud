<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Tag;

use Kiboko\Cloud\Domain\Packaging;

interface TagInterface extends \Stringable
{
    public function getContext(): Packaging\Context\ContextInterface;
    public function getRepository(): Packaging\RepositoryInterface;
}
