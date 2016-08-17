<?php

namespace Kiboko\Component\MagentoDriver\Model;

use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;

trait AttributeValueTrait
{
    /**
     * @var int
     */
    private $identifier;

    /**
     * @var ProductInterface
     */
    private $product;

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
     *
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
        return $this->isScopable() ? $this->identifier : null;
    }

    /**
     * @param int $identifier
     */
    public function persistedToId($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return int
     */
    public function getProductId()
    {
        if ($this->product === null) {
            return;
        }

        return $this->product->getId();
    }

    /**
     * @param ProductInterface $product
     *
     * @return AttributeValueInterface
     */
    public function attachToProduct(ProductInterface $product)
    {
        $this->product = $product;
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
     *
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
     *
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
    
    /**
     * @return int
     */
    public function getEntityTypeId()
    {
        return $this->attribute->getEntityTypeId();
    }
}
