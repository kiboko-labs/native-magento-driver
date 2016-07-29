<?php

namespace Kiboko\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoDriver\Factory\ProductUrlRewriteFactoryInterface;
use Kiboko\Component\MagentoDriver\Model\ProductUrlRewriteInterface;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\EnterpriseEditionProductUrlRewriteQueryBuilderInterface;

class EnterpriseEditionProductUrlRewriteRepository extends AbstractProductUrlRewriteRepository
{
    /**
     * @param Connection                                              $connection
     * @param EnterpriseEditionProductUrlRewriteQueryBuilderInterface $queryBuilder
     * @param ProductUrlRewriteFactoryInterface                       $productUrlRewriteFactory
     */
    public function __construct(
        Connection $connection,
        EnterpriseEditionProductUrlRewriteQueryBuilderInterface $queryBuilder,
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
        $query = $this->queryBuilder->createFindOneByProductIdQueryBuilder('p', 'l');

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