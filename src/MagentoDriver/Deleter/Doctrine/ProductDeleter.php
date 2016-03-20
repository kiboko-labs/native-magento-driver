<?php

namespace Luni\Component\MagentoDriver\Deleter\Doctrine;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Deleter\ProductDeleterInterface;
use Luni\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\ProductQueryBuilderInterface;

class ProductDeleter
    implements ProductDeleterInterface
{
    /**
     * @var ProductQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     * @param ProductQueryBuilderInterface $queryBuilder
     */
    public function __construct(
        Connection $connection,
        ProductQueryBuilderInterface $queryBuilder
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @param int $id
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     * @throws DatabaseFetchingFailureException
     */
    public function deleteOneById($id)
    {
        $query = $this->queryBuilder->createDeleteOneByIdQueryBuilder();

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$id])) {
            throw new DatabaseFetchingFailureException();
        }

        return $statement->rowCount();
    }

    /**
     * @param int[] $idList
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     * @throws DatabaseFetchingFailureException
     */
    public function deleteAllById(array $idList)
    {
        $query = $this->queryBuilder->createDeleteAllByIdQueryBuilder($idList);

        $statement = $this->connection->prepare($query);
        if (!$statement->execute($idList)) {
            throw new DatabaseFetchingFailureException();
        }

        return $statement->rowCount();
    }

    /**
     * @param int $sku
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     * @throws DatabaseFetchingFailureException
     */
    public function deleteOneByIdentifier($sku)
    {
        $query = $this->queryBuilder->createDeleteOneByIdQueryBuilder();

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$sku])) {
            throw new DatabaseFetchingFailureException();
        }

        return $statement->rowCount();
    }

    /**
     * @param array $skuList
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     * @throws DatabaseFetchingFailureException
     */
    public function deleteAllByIdentifier(array $skuList)
    {
        $query = $this->queryBuilder->createDeleteAllByIdQueryBuilder($skuList);

        $statement = $this->connection->prepare($query);
        if (!$statement->execute($skuList)) {
            throw new DatabaseFetchingFailureException();
        }

        return $statement->rowCount();
    }
}