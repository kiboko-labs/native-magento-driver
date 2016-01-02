<?php

namespace Luni\Component\MagentoDriver\Factory;

use Luni\Component\MagentoDriver\Model\AttributeValueInterface;

interface ProductAttributeValueFactoryInterface
{
    /**
     * @param array $options
     * @return AttributeValueInterface
     */
    public function buildNew(array $options);
}