<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoDriver\Factory\ProductUrlRewriteFactoryInterface;
use Kiboko\Component\MagentoDriver\Model\ProductUrlRewriteInterface;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\CommunityEditionProductUrlRewriteQueryBuilderInterface;
use Kiboko\Component\MagentoDriver\Repository\ProductUrlRewriteRepositoryInterface;

abstract class AbstractProductUrlRewriteRepository implements ProductUrlRewriteRepositoryInterface
{
    /**
     * @var CommunityEditionProductUrlRewriteQueryBuilderInterface
     */
    protected $queryBuilder;

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var ProductUrlRewriteFactoryInterface
     */
    protected $productUrlRewriteFactory;

    /**
     * @param array $options
     *
     * @return ProductUrlRewriteInterface
     */
    protected function createNewProductUrlRewriteInstanceFromDatabase(array $options)
    {
        $product = $this->productUrlRewriteFactory->buildNew($options);

        return $product;
    }

    /**
     * @param ProductInterface $product
     * @param int $storeId
     * @return ProductUrlRewriteInterface
     */
    public function findOneByProduct(ProductInterface $product, $storeId)
    {
        return $this->findOneByProductId($product->getId(), $storeId);
    }
}
