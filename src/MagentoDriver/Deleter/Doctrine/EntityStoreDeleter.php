<?php

namespace Luni\Component\MagentoDriver\Deleter\Doctrine;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Deleter\EntityStoreDeleterInterface;
use Luni\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\EntityStoreQueryBuilderInterface;

class EntityStoreDeleter implements EntityStoreDeleterInterface
{
    /**
     * @var EntityStoreQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     * @param EntityStoreQueryBuilderInterface $queryBuilder
     */
    public function __construct(
        Connection $connection,
        EntityStoreQueryBuilderInterface $queryBuilder
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @param int $id
     *
     * @return int
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws DatabaseFetchingFailureException
     */
    public function deleteOneById($id)
    {
        $query = $this->queryBuilder->createDeleteOneByIdQueryBuilder('e');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$id])) {
            throw new DatabaseFetchingFailureException();
        }

        return $statement->rowCount();
    }

    /**
     * @param int[] $idList
     *
     * @return int
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws DatabaseFetchingFailureException
     */
    public function deleteAllById(array $idList)
    {
        $query = $this->queryBuilder->createDeleteAllByIdQueryBuilder('e');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute($idList)) {
            throw new DatabaseFetchingFailureException();
        }

        return $statement->rowCount();
    }
}