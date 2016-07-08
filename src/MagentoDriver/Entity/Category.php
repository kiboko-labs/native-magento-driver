<?php

namespace Kiboko\Component\MagentoDriver\Entity;

class Category implements CategoryInterface
{
    /**
     * @var int
     */
    private $identifier;

    /**
     * @param int $identifier
     *
     * @return static
     */
    public static function buildNewWith($identifier)
    {
        $instance = new static();

        $instance->identifier = $identifier;

        return $instance;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->identifier;
    }

    /**
     * @return \Traversable
     */
    public function getAttributes()
    {
        return new \ArrayIterator([]);
    }

    /**
     * @return \Traversable
     */
    public function getValues()
    {
        return new \ArrayIterator([]);
    }
}
