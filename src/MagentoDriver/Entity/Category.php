<?php

namespace Kiboko\Component\MagentoDriver\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

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

        $instance->id = $identifier;

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
     * @return Collection
     */
    public function getAttributes()
    {
        return new ArrayCollection();
    }

    /**
     * @return Collection
     */
    public function getValues()
    {
        return new ArrayCollection();
    }
}
