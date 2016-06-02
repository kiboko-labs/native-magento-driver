<?php

namespace Kiboko\Component\MagentoDriver\Deleter\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Deleter\AttributeDeleterInterface;
use Kiboko\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\AttributeQueryBuilderInterface;

class AttributeDeleter implements AttributeDeleterInterface
{
    /**
     * @var AttributeQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection                     $connection
     * @param AttributeQueryBuilderInterface $queryBuilder
     */
    public function __construct(
        Connection $connection,
        AttributeQueryBuilderInterface $queryBuilder
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

    /**
     * @param string $code
     *
     * @return int
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws DatabaseFetchingFailureException
     */
    public function deleteOneByCode($code)
    {
        $query = $this->queryBuilder->createDeleteOneByCodeQueryBuilder();

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$code])) {
            throw new DatabaseFetchingFailureException();
        }

        return $statement->rowCount();
    }

    /**
     * @param string[] $codeList
     *
     * @return int
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws DatabaseFetchingFailureException
     */
    public function deleteAllByCode(array $codeList)
    {
        $query = $this->queryBuilder->createDeleteAllByCodeQueryBuilder($codeList);

        $statement = $this->connection->prepare($query);
        if (!$statement->execute($codeList)) {
            throw new DatabaseFetchingFailureException();
        }

        return $statement->rowCount();
    }
}
