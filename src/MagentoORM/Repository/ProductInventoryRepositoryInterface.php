<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository;

use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoORM\Model\ProductInventoryInterface;

interface ProductInventoryRepositoryInterface
{
    /**
     * @param ProductInterface $product
     * @return ProductInventoryInterface
     */
    public function findOneByProduct(ProductInterface $product);
}
