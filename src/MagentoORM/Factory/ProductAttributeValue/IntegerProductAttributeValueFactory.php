<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory\ProductAttributeValue;

use Kiboko\Component\MagentoORM\Factory\ProductAttributeValueFactoryInterface;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\Immutable\ImmutableIntegerAttributeValue;
use Kiboko\Component\MagentoORM\Model\IntegerAttributeValueInterface;

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
            isset($options['value']) ? $options['value'] : null
        );
    }
}
