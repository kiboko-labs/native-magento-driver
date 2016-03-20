<?php

namespace Luni\Component\MagentoDriver\Factory;

use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;

interface ProductFactoryInterface
{
    /**
     * @param string $type
     * @param array $options
     * @return ProductInterface
     */
    public function buildNew($type, array $options);
}
