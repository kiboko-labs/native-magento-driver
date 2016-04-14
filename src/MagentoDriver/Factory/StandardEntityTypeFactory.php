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
            $options['entity_type_code']
        );
    }
}
