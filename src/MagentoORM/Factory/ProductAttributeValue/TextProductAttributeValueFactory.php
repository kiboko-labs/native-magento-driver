<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory\ProductAttributeValue;

use Kiboko\Component\MagentoORM\Factory\ProductAttributeValueFactoryInterface;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\Immutable\ImmutableTextAttributeValue;
use Kiboko\Component\MagentoORM\Model\TextAttributeValueInterface;

class TextProductAttributeValueFactory implements ProductAttributeValueFactoryInterface
{
    /**
     * @param AttributeInterface $attribute
     * @param array              $options
     *
     * @return TextAttributeValueInterface
     */
    public function buildNew(AttributeInterface $attribute, array $options)
    {
        return ImmutableTextAttributeValue::buildNewWith(
            $attribute,
            isset($options['value_id']) ? $options['value_id'] : null,
            isset($options['value']) ? $options['value'] : null
        );
    }
}
