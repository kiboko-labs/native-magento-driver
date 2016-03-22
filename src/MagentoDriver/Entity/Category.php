<?php

namespace Luni\Component\MagentoDriver\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Category implements CategoryInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @param int $id
     *
     * @return static
     */
    public static function buildNewWith($id)
    {
        $instance = new static();

        $instance->id = $id;

        return $instance;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
