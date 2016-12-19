<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\FieldMapping;

class PriorityChain implements
    \Countable,
    \IteratorAggregate,
    \Serializable,
    \ArrayAccess
{
    const OBJECT = 0;
    const PRIORITY = 1;

    /**
     * @var array
     */
    private $priorityList;

    /**
     * @var bool
     */
    private $dirty;

    /**
     * PriorityChain constructor.
     */
    public function __construct()
    {
        $this->priorityList = [];
        $this->dirty = false;
    }

    private function clean()
    {
        if (!$this->dirty) {
            return;
        }
        $this->dirty = false;

        usort($this->priorityList, function($left, $right) {
            return ($left[self::PRIORITY] <=> $right[self::PRIORITY]);
        });
    }

    /**
     * @return \Generator
     */
    public function getIterator()
    {
        $this->clean();

        foreach ($this->priorityList as $item) {
            yield $item[self::OBJECT];
        }
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->priorityList);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        foreach ($this->priorityList as $row) {
            if ($row[self::OBJECT] === $offset) {
                return true;
            }
        }
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        foreach ($this->priorityList as $row) {
            if ($row[self::OBJECT] === $offset) {
                return $row[self::PRIORITY];
            }
        }
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        foreach ($this->priorityList as &$row) {
            if ($row[self::OBJECT] === $offset) {
                $row[self::PRIORITY] = $value;
                $this->dirty = true;
                break;
            }
        }
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        foreach ($this->priorityList as &$row) {
            if ($row[self::OBJECT] === $offset) {
                unset($row);
                $this->dirty = true;
                break;
            }
        }
    }

    /**
     * @return string
     */
    public function serialize()
    {
        $this->clean();
        return serialize($this->priorityList);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $this->priorityList = unserialize($serialized);
        $this->dirty = true;
    }

    /**
     * @param object $item
     * @param int $priority
     */
    public function attach($item, $priority)
    {
        $this->dirty = true;
        $this->priorityList[] = [
            self::OBJECT => $item,
            self::PRIORITY => $priority
        ];
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
        foreach ($this->priorityList as &$row) {
            if ($row[self::OBJECT] === $item) {
                unset($row);
                $this->dirty = true;
                break;
            }
        }
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
