<?php

namespace Luni\Component\MagentoDriver\Factory;

use Luni\Component\MagentoDriver\Model\FamilyInterface;

interface FamilyFactoryInterface
{
    /**
     * @param array $options
     * @return FamilyInterface
     */
    public function buildNew(array $options);
}