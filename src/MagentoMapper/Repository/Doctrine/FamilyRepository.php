<?php

namespace Kiboko\Component\MagentoMapper\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoMapper\QueryBuilder\FamilyQueryBuilderInterface;
use Kiboko\Component\MagentoMapper\Repository\FamilyRepositoryInterface;

class FamilyRepository implements FamilyRepositoryInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var FamilyQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * AttributeRepository constructor.
     *
     * @param Connection                  $connection
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
            $attributeList[$options['family_code']] = $options['attribute_set_id'];
        }

        return $attributeList;
    }
}
