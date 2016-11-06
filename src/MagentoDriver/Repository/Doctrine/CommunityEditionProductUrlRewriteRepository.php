<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoDriver\Factory\ProductUrlRewriteFactoryInterface;
use Kiboko\Component\MagentoDriver\Model\ProductUrlRewriteInterface;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\CommunityEditionProductUrlRewriteQueryBuilderInterface;

class CommunityEditionProductUrlRewriteRepository extends AbstractProductUrlRewriteRepository
{
    /**
     * @param Connection                                             $connection
     * @param CommunityEditionProductUrlRewriteQueryBuilderInterface $queryBuilder
     * @param ProductUrlRewriteFactoryInterface                      $productUrlRewriteFactory
     */
    public function __construct(
        Connection $connection,
        CommunityEditionProductUrlRewriteQueryBuilderInterface $queryBuilder,
        ProductUrlRewriteFactoryInterface $productUrlRewriteFactory
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
        $this->productUrlRewriteFactory = $productUrlRewriteFactory;
    }

    /**
     * @param string $identifier
     * @param int $storeId
     *
     * @return ProductUrlRewriteInterface
     */
    public function findOneByProductId($identifier, $storeId)
    {
        $query = $this->queryBuilder->createFindOneByProductIdQueryBuilder('p');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$identifier, $storeId])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewProductUrlRewriteInstanceFromDatabase($options);
    }
}
