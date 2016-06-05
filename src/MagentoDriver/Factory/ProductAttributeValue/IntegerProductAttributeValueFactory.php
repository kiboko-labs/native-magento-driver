<?php

namespace Kiboko\Component\MagentoDriver\Factory\ProductAttributeValue;

use Kiboko\Component\MagentoDriver\Factory\ProductAttributeValueFactoryInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\Immutable\ImmutableIntegerAttributeValue;
use Kiboko\Component\MagentoDriver\Model\IntegerAttributeValueInterface;

class IntegerProductAttributeValueFactory implements ProductAttributeValueFactoryInterface
{
    /**
     * @param AttributeInterface $attribute
     * @param array              $options
     *
     * @return IntegerAttributeValueInterface
     */
    public function buildNew(AttributeInterface $attribute, array $options)
    {
        return ImmutableIntegerAttributeValue::buildNewWith(
            $attribute,
            isset($options['value_id']) ? $options['value_id'] : null,
            isset($options['value'])    ? $options['value'] : null
        );
    }
}
