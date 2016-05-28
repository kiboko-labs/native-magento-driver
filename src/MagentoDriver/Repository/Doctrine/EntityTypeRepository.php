<?php

namespace Kiboko\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoDriver\Factory\EntityTypeFactoryInterface;
use Kiboko\Component\MagentoDriver\Model\EntityTypeInterface;
use Kiboko\Component\MagentoDriver\QueryBuilder\Doctrine\EntityTypeQueryBuilderInterface;
use Kiboko\Component\MagentoDriver\Repository\EntityTypeRepositoryInterface;

class EntityTypeRepository implements EntityTypeRepositoryInterface
{
    /**
     * @var EntityTypeQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var EntityTypeFactoryInterface
     */
    private $entityFactory;

    /**
     * @param Connection                      $connection
     * @param EntityTypeQueryBuilderInterface $queryBuilder
     * @param EntityTypeFactoryInterface      $entityFactory
     */
    public function __construct(
    Connection $connection, EntityTypeQueryBuilderInterface $queryBuilder, EntityTypeFactoryInterface $entityFactory
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
        $this->entityFactory = $entityFactory;
    }

    /**
     * @param array $options
     *
     * @return EntityTypeInterface
     */
    protected function createNewEntityTypeInstanceFromDatabase(array $options)
    {
        return $this->entityFactory->buildNew($options);
    }

    /**
     * @param int $id
     *
     * @return EntityTypeInterface
     */
    public function findOneById($id)
    {
        $query = $this->queryBuilder->createFindOneByIdQueryBuilder('f');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$id])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewEntityTypeInstanceFromDatabase($options);
    }

    /**
     * @param string $code
     *
     * @return EntityTypeInterface
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

        return $this->createNewEntityTypeInstanceFromDatabase($options);
    }

    /**
     * @param string $entityTypeCode
     * @param array  $codeList
     *
     * @return Collection|EntityTypeInterface[]
     */
    public function findAllByCode($entityTypeCode, array $codeList)
    {
        $query = $this->queryBuilder->createFindAllByCodeQueryBuilder($entityTypeCode, $codeList);

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$code])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewEntityTypeInstanceFromDatabase($options);
    }

    /**
     * @param array|int[] $idList
     *
     * @return Collection|EntityTypeInterface[]
     */
    public function findAllById(array $idList)
    {
    }

    /**
     * @return Collection|EntityTypeInterface[]
     */
    public function findAll()
    {
    }
}
