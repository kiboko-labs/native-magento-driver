<?php

namespace Kiboko\Component\MagentoDriver\Repository\Dummy;

use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Model\ProductInventoryInterface;
use Kiboko\Component\MagentoDriver\Model\ProductUrlRewriteInterface;
use Kiboko\Component\MagentoDriver\Repository\ProductInventoryRepositoryInterface;
use Kiboko\Component\MagentoDriver\Repository\ProductPriceRepositoryInterface;
use Kiboko\Component\MagentoDriver\Repository\ProductUrlRewriteRepositoryInterface;

class ProductUrlRewriteRepository implements ProductUrlRewriteRepositoryInterface
{
    /**
     * @param string $identifier
     * @param int $storeId
     *
     * @return ProductUrlRewriteInterface
     */
    public function findOneByProductId($identifier, $storeId)
    {
        return null;
    }

    /**
     * @param ProductInterface $product
     * @param int $storeId
     * @return ProductUrlRewriteInterface
     */
    public function findOneByProduct(ProductInterface $product, $storeId)
    {
        return null;
    }
}