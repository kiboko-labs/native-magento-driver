<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

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
