<?php

namespace Kiboko\Component\Connector;

class PriorityChain implements
    \Countable,
    \IteratorAggregate,
    \Serializable,
    \ArrayAccess
{
    private $priorityList;

    /**
     * PriorityChain constructor.
     */
    public function __construct()
    {
        $this->priorityList = new \SplObjectStorage();
    }

    /**
     * @return \Generator
     */
    public function getIterator()
    {
        foreach ($this->priorityList as $item) {
            yield $item;
        }
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->priorityList->count();
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->priorityList->offsetExists($offset);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->priorityList->offsetGet($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->priorityList->offsetSet($offset, $value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->priorityList->offsetUnset($offset);
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return $this->priorityList->serialize();
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $this->priorityList->unserialize($serialized);
    }

    /**
     * @param object $item
     * @param int $priority
     */
    public function attach($item, $priority)
    {
        $this->priorityList->attach($item, $priority);
    }

    /**
     * @param object[] $items
     * @param int $priority
     */
    public function attachAll(array $items, $priority)
    {
        foreach ($items as $item) {
            $this->attach($item, $priority);
        }
    }

    /**
     * @param object $item
     */
    public function detach($item)
    {
        $this->priorityList->detach($item);
    }

    /**
     * @param object[] $items
     */
    public function detachAll(array $items)
    {
        foreach ($items as $item) {
            $this->detach($item);
        }
    }
}
