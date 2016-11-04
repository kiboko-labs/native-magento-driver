<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoMapper\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoMapper\QueryBuilder\AttributeGroupQueryBuilderInterface;
use Kiboko\Component\MagentoMapper\Repository\AttributeGroupRepositoryInterface;

class AttributeGroupRepository implements AttributeGroupRepositoryInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var AttributeGroupQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * AttributeRepository constructor.
     *
     * @param Connection                  $connection
     * @param AttributeGroupQueryBuilderInterface $queryBuilder
     */
    public function __construct(
        Connection $connection,
        AttributeGroupQueryBuilderInterface $queryBuilder
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @param string $groupCode
     * @param string $familyCode
     *
     * @return null|int
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findOneByCode($groupCode, $familyCode)
    {
        $query = $this->queryBuilder->createFindOneByCodeQueryBuilder('p');

        $statement = $this->connection->prepare($query);
        $statement->bindValue(1, $groupCode);
        $statement->bindValue(2, $familyCode);

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
            if (!isset($attributeList[$options['family_code']])) {
                $attributeList[$options['family_code']] = [];
            }
            $attributeList[$options['family_code']][$options['attribute_group_code']] = $options['attribute_group_id'];
        }

        return $attributeList;
    }
}
