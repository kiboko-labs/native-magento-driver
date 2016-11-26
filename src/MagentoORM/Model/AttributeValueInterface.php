<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;

interface AttributeValueInterface extends MappableInterface, IdentifiableInterface
{
    /**
     * @return int
     */
    public function getProductId();

    /**
     * @param ProductInterface $product
     *
     * @return AttributeValueInterface
     */
    public function attachToProduct(ProductInterface $product);

    /**
     * @return AttributeInterface
     *
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
     *
     * @return bool
     */
    public function isAttribute(AttributeInterface $friend);

    /**
     * @return string
     */
    public function getAttributeBackendType();

    /**
     * @param string $key
     *
     * @return string
     */
    public function getAttributeOption($key);

    /**
     * @return array
     */
    public function getAttributeOptions();
}
