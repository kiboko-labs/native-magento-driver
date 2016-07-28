<?php

namespace Kiboko\Component\MagentoDriver\Repository\Dummy;

use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Model\ProductInventoryInterface;
use Kiboko\Component\MagentoDriver\Repository\ProductInventoryRepositoryInterface;
use Kiboko\Component\MagentoDriver\Repository\ProductPriceRepositoryInterface;
use Kiboko\Component\MagentoDriver\Repository\ProductUrlRewriteRepositoryInterface;

class ProductUrlRewriteRepository implements ProductUrlRewriteRepositoryInterface
{
    public function findOneByProduct(ProductInterface $product)
    {
        return null;
    }
}