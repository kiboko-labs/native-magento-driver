<?php

namespace Luni\Component\MagentoDriver\Deleter\Doctrine;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Deleter\FamilyDeleterInterface;
use Luni\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\FamilyQueryBuilderInterface;

class FamilyDeleter
    implements FamilyDeleterInterface
{
    /**
     * @var FamilyQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     * @param FamilyQueryBuilderInterface $queryBuilder
     */
    public function __construct(
        Connection $connection,
        FamilyQueryBuilderInterface $queryBuilder
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
}