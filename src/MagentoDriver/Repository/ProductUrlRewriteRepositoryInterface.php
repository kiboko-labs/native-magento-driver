<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Model\ProductUrlRewriteInterface;

interface ProductUrlRewriteRepositoryInterface
{
    /**
     * @param string $identifier
     * @param int $storeId
     *
     * @return ProductUrlRewriteInterface
     */
    public function findOneByProductId($identifier, $storeId);

    /**
     * @param ProductInterface $product
     * @param int $storeId
     * @return ProductUrlRewriteInterface
     */
    public function findOneByProduct(ProductInterface $product, $storeId);
}
