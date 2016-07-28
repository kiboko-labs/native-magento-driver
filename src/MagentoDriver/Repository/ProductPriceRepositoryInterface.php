<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Model\ProductPriceInterface;

interface ProductPriceRepositoryInterface
{
    /**
     * @param ProductInterface $product
     * @return ProductPriceInterface
     */
    public function findOneByProduct(ProductInterface $product);
}