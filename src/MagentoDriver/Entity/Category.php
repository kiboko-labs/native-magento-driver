<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Entity;

use Kiboko\Component\MagentoDriver\Model\AttributeInterface;

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
     * @return string
     */
    public function getName()
    {
        return '';
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
