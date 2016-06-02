<?php

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Model\AttributeGroup;
use Kiboko\Component\MagentoDriver\Model\AttributeGroupInterface;

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
