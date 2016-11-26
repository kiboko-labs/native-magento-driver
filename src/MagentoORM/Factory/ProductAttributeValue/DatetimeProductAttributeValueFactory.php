<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory\ProductAttributeValue;

use Kiboko\Component\MagentoORM\Factory\ProductAttributeValueFactoryInterface;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\Immutable\ImmutableDatetimeAttributeValue;
use Kiboko\Component\MagentoORM\Model\DatetimeAttributeValueInterface;

class DatetimeProductAttributeValueFactory implements ProductAttributeValueFactoryInterface
{
    /**
     * @param AttributeInterface $attribute
     * @param array              $options
     *
     * @return DatetimeAttributeValueInterface
     */
    public function buildNew(AttributeInterface $attribute, array $options)
    {
        return ImmutableDatetimeAttributeValue::buildNewWith(
            isset($options['value_id']) ? $options['value_id'] : null,
            $attribute,
            isset($options['value']) ? $options['value'] : null
        );
    }
}
