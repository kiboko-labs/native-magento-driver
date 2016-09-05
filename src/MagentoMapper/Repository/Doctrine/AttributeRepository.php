<?php

namespace Kiboko\Component\MagentoMapper\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoMapper\QueryBuilder\AttributeQueryBuilderInterface;
use Kiboko\Component\MagentoMapper\Repository\AttributeRepositoryInterface;

class AttributeRepository implements AttributeRepositoryInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var AttributeQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * AttributeRepository constructor.
     *
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
     * @param string $code
     *
     * @return null|int
     *
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
            return;
        }

        $id = $statement->fetchColumn(0);
        if ($id === false) {
            return;
        }

        return $id;
    }

    /**
     * @return int[]
     *
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
            $attributeList[$options['attribute_code']] = $options['attribute_id'];
        }

        return $attributeList;
    }
}
