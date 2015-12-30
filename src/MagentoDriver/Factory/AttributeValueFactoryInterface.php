<?php

namespace Luni\Component\MagentoDriver\Factory;

use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;

interface AttributeValueFactoryInterface
{
    /**
     * @param int $attributeId
     * @param array $options
     * @return AttributeValueInterface
     */
    public function buildNew($attributeId, array $options);
}