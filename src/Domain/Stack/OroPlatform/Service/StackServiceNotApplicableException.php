<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\OroPlatform\Service;

final class StackServiceNotApplicableException extends \RuntimeException
{
    public static function noImageSatisfiesTheApplicationConstraint(string $serviceName, ?\Throwable $previous = null): self
    {
        return new self(strtr(
            'No image for service %serviceName% satisfies the application version constraint.',
            [
                '%serviceName%' => $serviceName,
            ]
        ), 0, $previous);
    }
    public static function tooOldVersion(?\Throwable $previous = null): self
    {
        return new self('Could not configure this stack version with ElasticStack, please review your wishes.', 0, $previous);
    }
}
