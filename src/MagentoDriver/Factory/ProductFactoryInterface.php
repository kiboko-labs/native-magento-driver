<?php

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;

interface ProductFactoryInterface
{
    /**
     * @param array  $options
     *
     * @return ProductInterface
     */
    public function buildNew(array $options);
}
