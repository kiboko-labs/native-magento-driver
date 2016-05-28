<?php

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Model\EntityAttribute;
use Kiboko\Component\MagentoDriver\Model\EntityAttributeInterface;

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
