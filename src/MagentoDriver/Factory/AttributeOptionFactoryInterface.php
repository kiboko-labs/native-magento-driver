<?php

namespace Luni\Component\MagentoDriver\Factory;

use Luni\Component\MagentoDriver\Model\AttributeOptionInterface;

interface AttributeOptionFactoryInterface
{
    /**
     * @param array $options
     *
     * @return AttributeOptionInterface
     */
    public function buildNew(array $options);
}
