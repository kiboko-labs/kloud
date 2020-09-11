<?php declare(strict_types=1);

namespace spec\Kiboko\Cloud\Domain\Stack\Compose\Normalizer;

use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\Expression;
use Kiboko\Cloud\Domain\Stack\Compose\InheritedEnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\Service;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use PhpSpec\ObjectBehavior;

final class ServiceDenormalizerSpec extends ObjectBehavior
{
    function it_detects_environment_variables_passthru()
    {
        $this->denormalize(
            [
                'image' => 'foo',
                'environment' => [
                    'LOREM_IPSUM',
                ],
            ],
            Service::class,
            'yaml',
            [
                'stack_service_name' => 'lorem_ipsum',
            ],
        )->shouldBeLike(
            (new Service('lorem_ipsum', 'foo'))
                ->addEnvironmentVariables(
                    new InheritedEnvironmentVariable(new Variable('LOREM_IPSUM'))
                ),
        );
    }

    function it_detects_environment_variables_assignment()
    {
        $this->denormalize(
            [
                'image' => 'foo',
                'environment' => [
                    'LOREM_IPSUM=1234',
                ],
            ],
            Service::class,
            'yaml',
            [
                'stack_service_name' => 'lorem_ipsum',
            ],
        )->shouldBeLike(
            (new Service('lorem_ipsum', 'foo'))
                ->addEnvironmentVariables(
                    new EnvironmentVariable(new Variable('LOREM_IPSUM'), '1234')
                ),
        );
    }

    function it_detects_environment_variables_assignment_from_variable()
    {
        $this->denormalize(
            [
                'image' => 'foo',
                'environment' => [
                    'LOREM_IPSUM=$DOLOR',
                ],
            ],
            Service::class,
            'yaml',
            [
                'stack_service_name' => 'lorem_ipsum',
            ],
        )->shouldBeLike(
            (new Service('lorem_ipsum', 'foo'))
                ->addEnvironmentVariables(
                    new EnvironmentVariable(new Variable('LOREM_IPSUM'), new Expression(new Variable('DOLOR')))
                ),
        );
    }

    function it_detects_environment_variables_assignment_from_expression()
    {
        $this->denormalize(
            [
                'image' => 'foo',
                'environment' => [
                    'LOREM_IPSUM=${DOLOR}-32',
                ],
            ],
            Service::class,
            'yaml',
            [
                'stack_service_name' => 'lorem_ipsum',
            ],
        )->shouldBeLike(
            (new Service('lorem_ipsum', 'foo'))
                ->addEnvironmentVariables(
                    new EnvironmentVariable(new Variable('LOREM_IPSUM'), new Expression(new Variable('DOLOR'), '-32'))
                ),
        );
    }
}