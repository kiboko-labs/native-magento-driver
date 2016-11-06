<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory;

use Kiboko\Component\MagentoORM\Model\EntityStore;
use Kiboko\Component\MagentoORM\Model\EntityStoreInterface;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class StandardEntityStoreFactory implements EntityStoreFactoryInterface
{
    /**
     * @param array $options
     *
     * @return EntityStoreInterface
     */
    public function buildNew(array $options)
    {
        return EntityStore::buildNewWith(
            $options['entity_store_id'],
            $options['entity_type_id'],
            $options['store_id'],
            $options['increment_prefix'],
            $options['increment_last_id']
        );
    }
}
