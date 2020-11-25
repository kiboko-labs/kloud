<?php declare(strict_types=1);

namespace spec\Kiboko\Cloud\Domain\Stack;

use Kiboko\Cloud\Domain\Packaging\RepositoryInterface;
use Kiboko\Cloud\Domain\Stack;
use PhpSpec\ObjectBehavior;

final class ContextBuilderSpec extends ObjectBehavior
{
    function it_is_initializable(RepositoryInterface $repository)
    {
        $this->beConstructedWith($repository, '7.4');
    }

    function it_is_initializing_properties(RepositoryInterface $repository)
    {
        $this->beConstructedWith($repository, '7.4');
        $this->getContext()->shouldReturnAnInstanceOf(Stack\DTO\Context::class);
    }
}
