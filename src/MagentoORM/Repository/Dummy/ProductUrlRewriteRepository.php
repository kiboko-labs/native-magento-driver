<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository\Dummy;

use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoORM\Model\ProductUrlRewriteInterface;
use Kiboko\Component\MagentoORM\Repository\ProductUrlRewriteRepositoryInterface;

class ProductUrlRewriteRepository implements ProductUrlRewriteRepositoryInterface
{
    /**
     * @param string $identifier
     * @param int    $storeId
     *
     * @return ProductUrlRewriteInterface
     */
    public function findOneByProductId($identifier, $storeId)
    {
        return null;
    }

    /**
     * @param ProductInterface $product
     * @param int              $storeId
     *
     * @return ProductUrlRewriteInterface
     */
    public function findOneByProduct(ProductInterface $product, $storeId)
    {
        return null;
    }
}
