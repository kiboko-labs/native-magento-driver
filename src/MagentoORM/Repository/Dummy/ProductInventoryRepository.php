<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository\Dummy;

use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoORM\Model\ProductInventory;
use Kiboko\Component\MagentoORM\Model\ProductInventoryInterface;
use Kiboko\Component\MagentoORM\Repository\ProductInventoryRepositoryInterface;

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
