<?php

namespace Luni\Component\MagentoDriver\Factory;

use Luni\Component\MagentoDriver\Model\Family;
use Luni\Component\MagentoDriver\Model\FamilyInterface;

class StandardFamilyFactory
    implements FamilyFactoryInterface
{
    /**
     * @param array $options
     * @return FamilyInterface
     */
    public function buildNew(array $options)
    {
        return Family::buildNewWith(
            $options['attribute_set_id'],
            $options['attribute_set_name']
        );
    }
}