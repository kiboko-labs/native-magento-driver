<?php

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Model\AttributeOptionInterface;

interface AttributeOptionFactoryInterface
{
    /**
     * @param array $options
     *
     * @return AttributeOptionInterface
     */
    public function buildNew(array $options);
}
