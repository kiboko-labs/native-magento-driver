<?php

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Model\AttributeOption;
use Kiboko\Component\MagentoDriver\Model\AttributeOptionInterface;

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
