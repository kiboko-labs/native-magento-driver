<?php

namespace Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Luni\Component\MagentoDriver\Factory\AttributeGroupFactoryInterface;
use Luni\Component\MagentoDriver\Model\AttributeGroupInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\AttributeGroupQueryBuilderInterface;
use Luni\Component\MagentoDriver\Repository\AttributeGroupRepositoryInterface;

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
     * @param int $id
     *
     * @return AttributeGroupInterface
     */
    public function findOneById($id)
    {
        $query = $this->queryBuilder->createFindOneByIdQueryBuilder('eav_g');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$id])) {
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
