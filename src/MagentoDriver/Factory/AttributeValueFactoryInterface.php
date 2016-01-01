<?php

namespace Luni\Component\MagentoDriver\Factory;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;

interface AttributeValueFactoryInterface
{
    /**
     * @param AttributeInterface $attribute
     * @param array $options
     * @return AttributeValueInterface
     */
    public function buildNew(AttributeInterface $attribute, array $options);
}