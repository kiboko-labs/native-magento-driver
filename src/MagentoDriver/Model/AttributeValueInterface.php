<?php

namespace Luni\Component\MagentoDriver\Model;

use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\Model\AttributeInterface;

interface AttributeValueInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return int
     */
    public function getProductId();

    /**
     * @param ProductInterface $product
     * @return AttributeValueInterface
     */
    public function attachToProduct(ProductInterface $product);

    /**
     * @return AttributeInterface
     * @internal
     */
    public function getAttribute();

    /**
     * @return int
     */
    public function getAttributeId();

    /**
     * @return string
     */
    public function getAttributeCode();

    /**
     * @return bool
     */
    public function isScopable();

    /**
     * @param AttributeInterface $friend
     * @return bool
     */
    public function isAttribute(AttributeInterface $friend);

    /**
     * @return string
     */
    public function getAttributeBackendType();

    /**
     * @param string $key
     * @return string
     */
    public function getAttributeOption($key);

    /**
     * @return array
     */
    public function getAttributeOptions();
}
