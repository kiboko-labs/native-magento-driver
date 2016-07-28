<?php

namespace Kiboko\Component\MagentoDriver\Repository\Dummy;

use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Model\ProductInventory;
use Kiboko\Component\MagentoDriver\Model\ProductInventoryInterface;
use Kiboko\Component\MagentoDriver\Repository\ProductInventoryRepositoryInterface;

class ProductInventoryRepository implements ProductInventoryRepositoryInterface
{
    /**
     * @param ProductInterface $product
     * @return ProductInventoryInterface|null
     */
    public function findOneByProduct(ProductInterface $product)
    {
        return new ProductInventory();
    }
}