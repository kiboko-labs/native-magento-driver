<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoDriver\Factory\EntityStoreFactoryInterface;
use Kiboko\Component\MagentoDriver\Model\EntityStoreInterface;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\EntityStoreQueryBuilderInterface;
use Kiboko\Component\MagentoDriver\Repository\EntityStoreRepositoryInterface;

class EntityStoreRepository implements EntityStoreRepositoryInterface
{
    /**
     * @var EntityStoreQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var EntityStoreFactoryInterface
     */
    private $entityFactory;

    /**
     * @param Connection                       $connection
     * @param EntityStoreQueryBuilderInterface $queryBuilder
     * @param EntityStoreFactoryInterface      $entityFactory
     */
    public function __construct(
    Connection $connection, EntityStoreQueryBuilderInterface $queryBuilder, EntityStoreFactoryInterface $entityFactory
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
        $this->entityFactory = $entityFactory;
    }

    /**
     * @param array $options
     *
     * @return EntityStoreInterface
     */
    protected function createNewEntityStoreInstanceFromDatabase(array $options)
    {
        return $this->entityFactory->buildNew($options);
    }

    /**
     * @param int $identifier
     *
     * @return EntityStoreInterface
     */
    public function findOneById($identifier)
    {
        $query = $this->queryBuilder->createFindOneByIdQueryBuilder('e');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$identifier])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewEntityStoreInstanceFromDatabase($options);
    }

    /**
     * @param string $storeId
     *
     * @return EntityStoreInterface
     */
    public function findOneByStoreId($storeId)
    {
        $query = $this->queryBuilder->createFindOneByStoreIdQueryBuilder('e');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$storeId])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewEntityStoreInstanceFromDatabase($options);
    }

    /**
     * @param string $typeId
     *
     * @return EntityStoreInterface
     */
    public function findOneByTypeId($typeId)
    {
        $query = $this->queryBuilder->createFindOneByTypeIdQueryBuilder('e');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$typeId])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewEntityStoreInstanceFromDatabase($options);
    }

    /**
     * @return Collection|EntityStoreInterface[]
     */
    public function findAll()
    {
        $query = $this->queryBuilder->createFindAllQueryBuilder('e');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute()) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetchAll();

        foreach ($options as $option) {
            $results[] = $this->createNewEntityStoreInstanceFromDatabase($option);
        }

        return $results;
    }
}
