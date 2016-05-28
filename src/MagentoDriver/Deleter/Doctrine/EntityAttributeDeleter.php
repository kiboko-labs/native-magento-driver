<?php

namespace Kiboko\Component\MagentoDriver\Deleter\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Deleter\EntityAttributeDeleterInterface;
use Kiboko\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\EntityAttributeQueryBuilderInterface;

class EntityAttributeDeleter implements EntityAttributeDeleterInterface
{
    /**
     * @var EntityAttributeQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection                           $connection
     * @param EntityAttributeQueryBuilderInterface $queryBuilder
     */
    public function __construct(
        Connection $connection,
        EntityAttributeQueryBuilderInterface $queryBuilder
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
        $query = $this->queryBuilder->createDeleteOneByIdQueryBuilder();

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
        $query = $this->queryBuilder->createDeleteAllByIdQueryBuilder($idList);

        $statement = $this->connection->prepare($query);
        if (!$statement->execute($idList)) {
            throw new DatabaseFetchingFailureException();
        }

        return $statement->rowCount();
    }
}
