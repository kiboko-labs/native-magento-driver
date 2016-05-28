<?php

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeValueInterface;

interface ProductAttributeValueFactoryInterface extends AttributeValueFactoryInterface
{
    /**
     * @param AttributeInterface $attribute
     * @param array              $options
     *
     * @return AttributeValueInterface
     */
    public function buildNew(AttributeInterface $attribute, array $options);
}
