<?php

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Model\AttributeOptionValue;
use Kiboko\Component\MagentoDriver\Model\AttributeOptionValueInterface;

class AttributeOptionValueFactory implements AttributeOptionValueFactoryInterface
{
    /**
     * @param array $options
     *
     * @return AttributeOptionValueInterface
     */
    public function buildNew(array $options)
    {
        return AttributeOptionValue::buildNewWith(
            $options['value_id'],
            $options['option_id'],
            $options['store_id'],
            isset($options['value']) ? $options['value'] : null
        );
    }
}
