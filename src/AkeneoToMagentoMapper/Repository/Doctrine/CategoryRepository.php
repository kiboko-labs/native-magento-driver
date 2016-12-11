<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\AndWhereDoctrineFixForPHP7;
use Kiboko\Component\MagentoORM\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\AkeneoToMagentoMapper\QueryBuilder\Doctrine\CategoryQueryBuilder;
use Kiboko\Component\AkeneoToMagentoMapper\Repository\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    use AndWhereDoctrineFixForPHP7;

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
     *
     * @param Connection           $connection
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
     * @param string[] $codes
     *
     * @return int[]
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findAllByCodes(array $codes)
    {
        if (count($codes) <= 0) {
            return [];
        }

        $query = $this->queryBuilder->createFindAllQueryBuilder('p');

        $expr = array_pad([], count($codes), $query->expr()->eq('p.category_id', '?'));
        $this->andWhere(
            $query,
            $query->expr()->andX(...$expr)
        );

        $statement = $this->connection->prepare($query);
        if (!$statement->execute($codes)) {
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
            $attributeList[$options['category_code']] = $options['category_id'];
        }

        return $attributeList;
    }
}
