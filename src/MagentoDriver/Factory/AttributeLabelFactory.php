<?php

namespace Luni\Component\MagentoDriver\Factory;

use Luni\Component\MagentoDriver\Model\AttributeGroup;
use Luni\Component\MagentoDriver\Model\AttributeGroupInterface;

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
