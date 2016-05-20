<?php

namespace Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Luni\Component\MagentoDriver\Factory\EntityAttributeFactoryInterface;
use Luni\Component\MagentoDriver\Model\EntityAttributeInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\EntityAttributeQueryBuilderInterface;
use Luni\Component\MagentoDriver\Repository\EntityAttributeRepositoryInterface;

class EntityAttributeRepository implements EntityAttributeRepositoryInterface
{
    /**
     * @var EntityAttributeQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var EntityAttributeFactoryInterface
     */
    private $entityAttributeFactory;

    /**
     * @param Connection                           $connection
     * @param EntityAttributeQueryBuilderInterface $queryBuilder
     * @param EntityAttributeFactoryInterface      $entityAttributeFactory
     */
    public function __construct(
        Connection $connection,
        EntityAttributeQueryBuilderInterface $queryBuilder,
        EntityAttributeFactoryInterface $entityAttributeFactory
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
        $this->entityAttributeFactory = $entityAttributeFactory;
    }

    /**
     * @param array $options
     *
     * @return EntityAttributeInterface
     */
    protected function createNewEntityAttributeInstanceFromDatabase(array $options)
    {
        return $this->entityAttributeFactory->buildNew($options);
    }

    /**
     * @param int $id
     *
     * @return EntityAttributeInterface
     */
    public function findOneById($id)
    {
        $query = $this->queryBuilder->createFindOneByIdQueryBuilder('eav_e');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$id])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewEntityAttributeInstanceFromDatabase($options);
    }

    /**
     * @return Collection|EntityAttributeInterface[]
     *
     * @throws DatabaseFetchingFailureException
     */
    public function findAll()
    {
        $query = $this->queryBuilder->createFindQueryBuilder('eav_e');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute()) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetchAll();

        foreach ($options as $option) {
            $results[] = $this->createNewEntityAttributeInstanceFromDatabase($option);
        }

        return $results;
    }

    public function findOneByAttributeIdAndGroupId($attributeId, $attributeGroupId)
    {
        $query = $this->queryBuilder->createFindOneByAttributeIdAndGroupIdQueryBuilder('eav_e', $attributeId, $attributeGroupId);

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$attributeId, $attributeGroupId])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewEntityAttributeInstanceFromDatabase($options);
    }

    public function findOneByAttributeIdAndSetId($attributeId, $attributeSetId)
    {
        $query = $this->queryBuilder->createFindOneByAttributeIdAndSetIdQueryBuilder('eav_e', $attributeId, $attributeSetId);

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$attributeId, $attributeSetId])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewEntityAttributeInstanceFromDatabase($options);
    }
}
