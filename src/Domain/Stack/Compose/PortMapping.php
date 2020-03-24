<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\Compose;

final class PortMapping implements \Stringable
{
    /** @var int|Variable */
    private $out;
    /** @var null|int|Variable */
    private $in;

    public function __construct($out, $in = null)
    {
        if (!$out instanceof Variable && !is_int($out)) {
            throw new \InvalidArgumentException('The first argument should be either an integer or a Variable object.');
        }

        if (!$in instanceof Variable && !is_int($in) && $in !== null) {
            throw new \InvalidArgumentException('The second argument should be either null, an integer or a Variable object.');
        }

        $this->out = $out;
        $this->in = $in;
    }

    public function __toString()
    {
        if ($this->in === null) {
            return sprintf('%s', $this->out);
        }

        return sprintf('%s:%s', $this->out, $this->in);
    }

    public function getPortOnHost()
    {
        return $this->out;
    }

    public function getPortOnContainer()
    {
        return $this->in ?? $this->out;
    }
}