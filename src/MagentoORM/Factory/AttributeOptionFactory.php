<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory;

use Kiboko\Component\MagentoORM\Model\AttributeOption;
use Kiboko\Component\MagentoORM\Model\AttributeOptionInterface;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class AttributeOptionFactory implements AttributeOptionFactoryInterface
{
    /**
     * @param array $options
     *
     * @return AttributeOptionInterface
     */
    public function buildNew(array $options)
    {
        return AttributeOption::buildNewWith(
            $options['option_id'],
            $options['attribute_id'],
            $options['sort_order']
        );
    }
}
