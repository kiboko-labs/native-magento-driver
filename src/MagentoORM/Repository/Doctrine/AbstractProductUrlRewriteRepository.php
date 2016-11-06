<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoORM\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoORM\Factory\ProductUrlRewriteFactoryInterface;
use Kiboko\Component\MagentoORM\Model\ProductUrlRewriteInterface;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\CommunityEditionProductUrlRewriteQueryBuilderInterface;
use Kiboko\Component\MagentoORM\Repository\ProductUrlRewriteRepositoryInterface;

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
