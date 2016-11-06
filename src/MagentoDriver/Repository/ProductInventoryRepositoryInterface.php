<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Model\ProductInventoryInterface;

interface ProductInventoryRepositoryInterface
{
    /**
     * @param ProductInterface $product
     * @return ProductInventoryInterface
     */
    public function findOneByProduct(ProductInterface $product);
}
