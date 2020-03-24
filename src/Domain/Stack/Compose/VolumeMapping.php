<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\Compose;

final class VolumeMapping implements \Stringable
{
    /** @var string|\Stringable */
    private $out;
    /** @var string|\Stringable */
    private $in;
    private bool $isReadonly;

    /**
     * @param string|\Stringable $out
     * @param string|\Stringable $in
     */
    public function __construct($out, $in, bool $isReadonly = false)
    {
        if (!is_string($out) && !$out instanceof \Stringable) {
            throw new \TypeError('Argument 1 should be either a string or a \Stringable object.');
        }
        if (!is_string($in) && !$in instanceof \Stringable) {
            throw new \TypeError('Argument 2 should be either a string or a \Stringable object.');
        }

        $this->out = $out;
        $this->in = $in;
        $this->isReadonly = $isReadonly;
    }

    public function __toString()
    {
        if ($this->isReadonly) {
            return sprintf('%s:%s:ro', $this->out, $this->in);
        }

        return sprintf('%s:%s', $this->out, $this->in);
    }

    public function getHostPath()
    {
        return $this->out;
    }

    public function getContainerPath()
    {
        return $this->in;
    }

    public function isReadonly(): bool
    {
        return $this->isReadonly;
    }
}