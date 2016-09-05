<?php

namespace Kiboko\Component\MagentoDriver\Model;

use Kiboko\Component\MagentoDriver\Entity\Product\ConfigurableProductInterface;

interface SuperAttributeInterface extends MappableInterface, IdentifiableInterface
{
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
}
