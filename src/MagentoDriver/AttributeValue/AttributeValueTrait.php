<?php

namespace Luni\Component\MagentoDriver\AttributeValue;

use Luni\Component\MagentoDriver\Attribute\AttributeInterface;

trait AttributeValueTrait
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $storeId;

    /**
     * @var AttributeInterface
     */
    private $attribute;

    /**
     * @param AttributeInterface $friend
     * @return bool
     */
    public function isAttribute(AttributeInterface $friend)
    {
        return $this->attribute->getCode() === $friend->getCode();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * @return int
     */
    public function getAttributeId()
    {
        return $this->attribute->getId();
    }

    /**
     * @return string
     */
    public function getAttributeCode()
    {
        return $this->attribute->getCode();
    }
}