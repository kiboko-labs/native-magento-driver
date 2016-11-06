<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoORM\Factory\AttributeGroupFactoryInterface;
use Kiboko\Component\MagentoORM\Model\AttributeGroupInterface;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\AttributeGroupQueryBuilderInterface;
use Kiboko\Component\MagentoORM\Repository\AttributeGroupRepositoryInterface;

class AttributeGroupRepository implements AttributeGroupRepositoryInterface
{
    /**
     * @var AttributeGroupQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var AttributeGroupFactoryInterface
     */
    private $attributeGroupFactory;

    /**
     * @param Connection                          $connection
     * @param AttributeGroupQueryBuilderInterface $queryBuilder
     * @param AttributeGroupFactoryInterface      $attributeGroupFactory
     */
    public function __construct(
        Connection $connection,
        AttributeGroupQueryBuilderInterface $queryBuilder,
        AttributeGroupFactoryInterface $attributeGroupFactory
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
        $this->attributeGroupFactory = $attributeGroupFactory;
    }

    /**
     * @param array $options
     *
     * @return AttributeGroupInterface
     */
    protected function createNewAttributeGroupInstanceFromDatabase(array $options)
    {
        return $this->attributeGroupFactory->buildNew($options);
    }

    /**
     * @param int $identifier
     *
     * @return AttributeGroupInterface
     */
    public function findOneById($identifier)
    {
        $query = $this->queryBuilder->createFindOneByIdQueryBuilder('eav_g');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$identifier])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewAttributeGroupInstanceFromDatabase($options);
    }

    /**
     * @param string $name
     *
     * @return AttributeGroupInterface
     */
    public function findOneByName($name)
    {
        $query = $this->queryBuilder->createFindOneByNameQueryBuilder('eav_g');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$name])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewAttributeGroupInstanceFromDatabase($options);
    }
}
