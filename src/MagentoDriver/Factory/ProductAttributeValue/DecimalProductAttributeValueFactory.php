<?php

namespace Kiboko\Component\MagentoDriver\Factory\ProductAttributeValue;

use Kiboko\Component\MagentoDriver\Factory\ProductAttributeValueFactoryInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\Immutable\ImmutableDecimalAttributeValue;
use Kiboko\Component\MagentoDriver\Model\DecimalAttributeValueInterface;

class DecimalProductAttributeValueFactory implements ProductAttributeValueFactoryInterface
{
    /**
     * @param AttributeInterface $attribute
     * @param array              $options
     *
     * @return DecimalAttributeValueInterface
     */
    public function buildNew(AttributeInterface $attribute, array $options)
    {
        return ImmutableDecimalAttributeValue::buildNewWith(
            $attribute,
            isset($options['value_id']) ? $options['value_id'] : null,
            isset($options['value'])    ? $options['value'] : null
        );
    }
}
