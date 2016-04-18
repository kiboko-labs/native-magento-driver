<?php

namespace Luni\Component\MagentoDriver\Factory;

use Luni\Component\MagentoDriver\Model\EntityType;
use Luni\Component\MagentoDriver\Model\EntityTypeInterface;

class StandardEntityTypeFactory implements EntityTypeFactoryInterface
{
    /**
     * @param array $options
     *
     * @return EntityTypeInterface
     */
    public function buildNew(array $options)
    {
        return EntityType::buildNewWith(
            $options['entity_type_id'],
            $options['entity_type_code'],
            $options['entity_model'],
            $options['attribute_model'],
            $options['entity_table'],
            $options['value_table_prefix'],
            $options['entity_id_field'],
            $options['is_data_sharing'],
            $options['data_sharing_key'],
            $options['default_attribute_set_id'],
            $options['increment_model'],
            $options['increment_per_store'],
            $options['increment_pad_length'],
            $options['increment_pad_char'],
            $options['additional_attribute_table'],
            $options['entity_attribute_collection']        
        );
    }
}
