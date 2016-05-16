<?php

namespace Luni\Component\MagentoDriver\Factory;

use Luni\Component\MagentoDriver\Model\EntityAttribute;
use Luni\Component\MagentoDriver\Model\EntityAttributeInterface;

class EntityAttributeFactory implements EntityAttributeFactoryInterface
{
    /**
     * @param array $options
     *
     * @return EntityAttributeInterface
     */
    public function buildNew(array $options)
    {
        return EntityAttribute::buildNewWith(
            $options['entity_attribute_id'],
            $options['entity_type_id'],
            $options['attribute_set_id'],
            $options['attribute_group_id'],
            $options['attribute_id'],
            $options['sort_order']
        );
    }
}
