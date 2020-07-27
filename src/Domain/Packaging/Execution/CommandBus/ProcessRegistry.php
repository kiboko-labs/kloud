<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Packaging\Execution\CommandBus;

final class ProcessRegistry implements \ArrayAccess, \Iterator, \Countable
{
    private \SplObjectStorage $storage;

    public function __construct()
    {
        $this->storage = new \SplObjectStorage();
    }

    public function offsetExists($offset)
    {
        return $this->storage->offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        return $this->storage->offsetGet($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->storage->offsetSet($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->storage->offsetUnset($offset);
    }

    public function current()
    {
        return $this->storage->current();
    }

    public function next()
    {
        $this->storage->next();
    }

    public function key()
    {
        return $this->storage->key();
    }

    public function valid()
    {
        return $this->storage->valid();
    }

    public function rewind()
    {
        $this->storage->rewind();
    }

    public function count()
    {
        return $this->storage->count();
    }
}