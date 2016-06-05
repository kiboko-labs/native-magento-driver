<?php

namespace Kiboko\Component\MagentoDriver\Matcher;

use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;

interface ProductDataMatcherInterface
{
    /**
     * @param array $productData
     *
     * @return bool
     */
    public function match(array $productData);
}
