<?php

namespace Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Luni\Component\MagentoDriver\Factory\EntityTypeFactoryInterface;
use Luni\Component\MagentoDriver\Model\EntityTypeInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\EntityTypeQueryBuilderInterface;
use Luni\Component\MagentoDriver\Repository\EntityTypeRepositoryInterface;

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
        return $this->familyFactory->buildNew($options);
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
}
