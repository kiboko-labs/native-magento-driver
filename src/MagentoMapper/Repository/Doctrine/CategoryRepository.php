<?php

namespace Luni\Component\MagentoMapper\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Luni\Component\MagentoMapper\QueryBuilder\Doctrine\CategoryQueryBuilder;
use Luni\Component\MagentoMapper\Repository\CategoryRepositoryInterface;

class CategoryRepository
    implements CategoryRepositoryInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var CategoryQueryBuilder
     */
    private $queryBuilder;

    /**
     * AttributeRepository constructor.
     * @param Connection $connection
     * @param CategoryQueryBuilder $queryBuilder
     */
    public function __construct(
        Connection $connection,
        CategoryQueryBuilder $queryBuilder
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @param string $code
     * @return null|int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findOneByCode($code)
    {
        $query = $this->queryBuilder->createFindOneByCodeQueryBuilder('p');

        $statement = $this->connection->prepare($query);
        $statement->bindValue(1, $code);

        if (!$statement->execute()) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return null;
        }

        $id = $statement->fetchColumn(0);
        if ($id === false) {
            return null;
        }

        return $id;
    }

    /**
     * @return int[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findAll()
    {
        $query = $this->queryBuilder->createFindAllQueryBuilder('p');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute()) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return [];
        }

        $attributeList = [];
        foreach ($statement as $options) {
            $attributeList[$options['category_code']] = $options['category_id'];
        }

        return $attributeList;
    }
}