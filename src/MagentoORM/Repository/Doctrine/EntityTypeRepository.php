<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository\Doctrine;

use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoORM\Factory\EntityTypeFactoryInterface;
use Kiboko\Component\MagentoORM\Model\EntityTypeInterface;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\EntityTypeQueryBuilderInterface;
use Kiboko\Component\MagentoORM\Repository\EntityTypeRepositoryInterface;

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
        Connection $connection,
        EntityTypeQueryBuilderInterface $queryBuilder,
        EntityTypeFactoryInterface $entityFactory
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
     * @param int $identifier
     *
     * @return EntityTypeInterface
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

        return $this->createNewEntityTypeInstanceFromDatabase($options);
    }

    /**
     * @param string $code
     *
     * @return EntityTypeInterface
     */
    public function findOneByCode($code)
    {
        $query = $this->queryBuilder->createFindOneByCodeQueryBuilder('e');

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
     * @param array $codeList
     *
     * @return Collection|EntityTypeInterface[]
     */
    public function findAllByCode(array $codeList)
    {
        $query = $this->queryBuilder->createFindAllByCodeQueryBuilder('e', $codeList);

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$codeList])) {
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
        $query = $this->queryBuilder->createFindAllByIdQueryBuilder('e', $idList);

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$idList])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewEntityTypeInstanceFromDatabase($options);
    }

    /**
     * @return Collection|EntityTypeInterface[]
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

        $options = $statement->fetch();

        return $this->createNewEntityTypeInstanceFromDatabase($options);
    }
}
