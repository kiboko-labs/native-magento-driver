<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory;

use Kiboko\Component\MagentoORM\Model\EntityAttribute;
use Kiboko\Component\MagentoORM\Model\EntityAttributeInterface;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
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
