<?php

namespace Luni\Component\MagentoDriver\Factory;

use Luni\Component\MagentoDriver\Model\AttributeOptionValueInterface;

interface AttributeOptionValueFactoryInterface
{
    /**
     * @param array $options
     *
     * @return AttributeOptionValueInterface
     */
    public function buildNew(array $options);
}
