<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Model\ProductUrlRewriteInterface;

interface ProductUrlRewriteRepositoryInterface
{
    /**
     * @param ProductInterface $product
     * @return ProductUrlRewriteInterface
     */
    public function findOneByProduct(ProductInterface $product);
}