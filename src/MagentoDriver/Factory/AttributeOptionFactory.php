<?php

namespace Luni\Component\MagentoDriver\Factory;

use Luni\Component\MagentoDriver\Model\AttributeOption;
use Luni\Component\MagentoDriver\Model\AttributeOptionInterface;

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
