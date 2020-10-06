<?php declare(strict_types=1);

namespace spec\Kiboko\Cloud\Domain\Stack;

use Kiboko\Cloud\Domain\Stack;
use PhpSpec\ObjectBehavior;

final class ContextBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('7.4');
    }

    function it_is_initializing_properties()
    {
        $this->beConstructedWith('7.4');
        $this->getContext()->shouldReturnAnInstanceOf(Stack\DTO\Context::class);
    }
}