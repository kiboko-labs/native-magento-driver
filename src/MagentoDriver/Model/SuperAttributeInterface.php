<?php

namespace Kiboko\Component\MagentoDriver\Model;

use Kiboko\Component\MagentoDriver\Entity\Product\ConfigurableProductInterface;

interface SuperAttributeInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return int
     */
    public function getAttributeId();

    /**
     * @return int
     */
    public function getProductId();

    /**
     * @return int
     */
    public function getPosition();

    /**
     * @param ConfigurableProductInterface $configurable
     *
     * @return bool
     */
    public function isProduct(ConfigurableProductInterface $configurable);

    /**
     * @param AttributeInterface $attribute
     *
     * @return bool
     */
    public function isAttribute(AttributeInterface $attribute);

    /**
     * @param int $id
     */
    public function persistedToId($id);
}
