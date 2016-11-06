<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoORM\Factory\StoreFactoryInterface;
use Kiboko\Component\MagentoORM\Model\Store;
use Kiboko\Component\MagentoORM\Model\StoreInterface;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\StoreQueryBuilderInterface;
use Kiboko\Component\MagentoORM\Repository\StoreRepositoryInterface;

class StoreRepository implements StoreRepositoryInterface
{
    /**
     * @var StoreQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection                 $connection
     * @param StoreQueryBuilderInterface $queryBuilder
     */
    public function __construct(
        Connection $connection,
        StoreQueryBuilderInterface $queryBuilder
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @param array $options
     *
     * @return StoreInterface
     */
    protected function createNewStoreInstanceFromDatabase(array $options)
    {
        return new Store($options['store_id'], $options['code']);
    }

    /**
     * @param int $identifier
     *
     * @return StoreInterface
     */
    public function findOneById($identifier)
    {
        $query = $this->queryBuilder->createFindOneByIdQueryBuilder('f');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$identifier])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewStoreInstanceFromDatabase($options);
    }

    /**
     * @param string $code
     *
     * @return StoreInterface
     */
    public function findOneByCode($code)
    {
        $query = $this->queryBuilder->createFindOneByCodeQueryBuilder('f');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$code])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewStoreInstanceFromDatabase($options);
    }

    /**
     *
     * @return StoreInterface[]|\Traversable
     */
    public function findAll()
    {
        $query = $this->queryBuilder->createFindOneByCodeQueryBuilder('f');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute()) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewStoreInstanceFromDatabase($options);
    }
}
