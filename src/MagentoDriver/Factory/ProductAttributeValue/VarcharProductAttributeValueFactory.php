<?php

namespace Kiboko\Component\MagentoDriver\Factory\ProductAttributeValue;

use Kiboko\Component\MagentoDriver\Factory\ProductAttributeValueFactoryInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\Immutable\ImmutableVarcharAttributeValue;
use Kiboko\Component\MagentoDriver\Model\VarcharAttributeValueInterface;

class VarcharProductAttributeValueFactory implements ProductAttributeValueFactoryInterface
{
    /**
     * @param AttributeInterface $attribute
     * @param array $options
     * @return VarcharAttributeValueInterface
     */
    public function buildNew(AttributeInterface $attribute, array $options)
    {
        return ImmutableVarcharAttributeValue::buildNewWith(
            $attribute,
            isset($options['value_id']) ? $options['value_id'] : null,
            isset($options['value'])    ? $options['value'] : null
        );
    }
}