<?php

namespace Luni\Component\MagentoDriver\ModelValue;

use Luni\Component\MagentoDriver\Model\AttributeInterface;

trait AttributeValueTrait
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $productId;

    /**
     * @var int
     */
    private $storeId;

    /**
     * @var AttributeInterface
     */
    private $attribute;

    /**
     * @return bool
     */
    abstract public function isScopable();

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
        return $this->isScopable() ? $this->id : null;
    }

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->storeId;
    }

    /**
     * @return int
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * @return AttributeInterface
     * @internal
     */
    public function getAttribute()
    {
        return $this->attribute;
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

    /**
     * @return string
     */
    public function getAttributeBackendType()
    {
        return $this->attribute->getBackendType();
    }

    /**
     * @param string $key
     * @return string
     */
    public function getAttributeOption($key)
    {
        return $this->attribute->getOption($key);
    }

    /**
     * @return array
     */
    public function getAttributeOptions()
    {
        return $this->attribute->getOptions();
    }
}