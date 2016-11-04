<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Deleter\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Deleter\EntityStoreDeleterInterface;
use Kiboko\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\EntityStoreQueryBuilderInterface;

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
     * @param Connection                       $connection
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
     * @param int $identifier
     *
     * @return int
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws DatabaseFetchingFailureException
     */
    public function deleteOneById($identifier)
    {
        $query = $this->queryBuilder->createDeleteOneByIdQueryBuilder();

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$identifier])) {
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
