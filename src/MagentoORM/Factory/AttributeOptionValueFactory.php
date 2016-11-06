<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory;

use Kiboko\Component\MagentoORM\Model\AttributeOptionValue;
use Kiboko\Component\MagentoORM\Model\AttributeOptionValueInterface;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class AttributeOptionValueFactory implements AttributeOptionValueFactoryInterface
{
    /**
     * @param array $options
     *
     * @return AttributeOptionValueInterface
     */
    public function buildNew(array $options)
    {
        return AttributeOptionValue::buildNewWith(
            $options['value_id'],
            $options['option_id'],
            $options['store_id'],
            isset($options['value']) ? $options['value'] : null
        );
    }
}
