<?php

namespace Luni\Component\MagentoDriver\ModelValue;

use Luni\Component\MagentoDriver\Model\AttributeInterface;

interface AttributeValueInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return bool
     */
    public function isScopable();

    /**
     * @return int
     */
    public function getProductId();

    /**
     * @return int|null
     */
    public function getStoreId();

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