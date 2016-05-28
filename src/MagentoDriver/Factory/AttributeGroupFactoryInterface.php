<?php

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Model\AttributeGroupInterface;

interface AttributeGroupFactoryInterface
{
    /**
     * @param array $options
     *
     * @return AttributeGroupInterface
     */
    public function buildNew(array $options);
}
