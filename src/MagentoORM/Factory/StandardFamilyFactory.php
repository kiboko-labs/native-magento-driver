<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory;

use Kiboko\Component\MagentoORM\Model\Family;
use Kiboko\Component\MagentoORM\Model\FamilyInterface;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class StandardFamilyFactory implements FamilyFactoryInterface
{
    /**
     * @param array $options
     *
     * @return FamilyInterface
     */
    public function buildNew(array $options)
    {
        return Family::buildNewWith(
            $options['attribute_set_id'],
            $options['attribute_set_name'],
            $options['sort_order']
        );
    }
}
