<?php

namespace Kiboko\Component\MagentoDriver\Model;

use Kiboko\Component\MagentoDriver\Entity\Product\ConfigurableProductInterface;
use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;

class ProductSuperAttribute implements SuperAttributeInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var AttributeInterface
     */
    private $attribute;

    /**
     * @var ProductInterface
     */
    private $product;

    /**
     * @var int
     */
    private $position;

    /**
     * @param AttributeInterface $attribute
     * @param ProductInterface   $product
     * @param int                $position
     */
    public function __construct(
        AttributeInterface $attribute,
        ProductInterface $product,
        $position = null
    ) {
        $this->attribute = $attribute;
        $this->product = $product;
    }

    /**
     * @param int                $id
     * @param AttributeInterface $attribute
     * @param ProductInterface   $product
     * @param int                $position
     *
     * @return static
     */
    public static function buildNewWith(
        $id,
        AttributeInterface $attribute,
        ProductInterface $product,
        $position = null
    ) {
        $instance = new self($attribute, $product, $position);

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
     * @return int
     */
    public function getAttributeId()
    {
        return $this->attribute->getId();
    }

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->product->getId();
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param ConfigurableProductInterface $configurable
     *
     * @return bool
     */
    public function isProduct(ConfigurableProductInterface $configurable)
    {
        return $this->product === $configurable;
    }

    /**
     * @param AttributeInterface $attribute
     *
     * @return bool
     */
    public function isAttribute(AttributeInterface $attribute)
    {
        return $this->attribute === $attribute;
    }

    /**
     * @param int $id
     */
    public function persistedToId($id)
    {
        $this->id = $id;
    }
}
