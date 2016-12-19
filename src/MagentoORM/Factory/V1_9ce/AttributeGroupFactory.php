<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory\V1_9ce;

use Kiboko\Component\MagentoORM\Factory\AttributeGroupFactoryInterface;
use Kiboko\Component\MagentoORM\Model\V1_9ce\AttributeGroup;
use Kiboko\Component\MagentoORM\Model\AttributeGroupInterface;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class AttributeGroupFactory implements AttributeGroupFactoryInterface
{
    /**
     * @param array $options
     *
     * @return AttributeGroupInterface
     */
    public function buildNew(array $options)
    {
        return AttributeGroup::buildNewWith(
            $options['attribute_group_id'],
            $options['attribute_set_id'],
            $options['attribute_group_name'],
            $options['sort_order'],
            isset($options['default_id']) ? $options['default_id'] : null
        );
    }
}
