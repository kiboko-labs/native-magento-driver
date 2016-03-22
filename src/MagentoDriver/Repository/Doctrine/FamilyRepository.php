<?php

namespace Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Luni\Component\MagentoDriver\Factory\FamilyFactoryInterface;
use Luni\Component\MagentoDriver\Model\FamilyInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\FamilyQueryBuilderInterface;
use Luni\Component\MagentoDriver\Repository\FamilyRepositoryInterface;

class FamilyRepository implements FamilyRepositoryInterface
{
    /**
     * @var FamilyQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var FamilyFactoryInterface
     */
    private $familyFactory;

    /**
     * @param Connection                  $connection
     * @param FamilyQueryBuilderInterface $queryBuilder
     * @param FamilyFactoryInterface      $familyFactory
     */
    public function __construct(
        Connection $connection,
        FamilyQueryBuilderInterface $queryBuilder,
        FamilyFactoryInterface $familyFactory
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
        $this->familyFactory = $familyFactory;
    }

    /**
     * @param array $options
     *
     * @return FamilyInterface
     */
    protected function createNewFamilyInstanceFromDatabase(array $options)
    {
        return $this->familyFactory->buildNew($options);
    }

    /**
     * @param int $id
     *
     * @return FamilyInterface
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

        return $this->createNewFamilyInstanceFromDatabase($options);
    }

    /**
     * @param string $name
     *
     * @return FamilyInterface
     */
    public function findOneByName($name)
    {
        $query = $this->queryBuilder->createFindOneByNameQueryBuilder('f');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$name])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewFamilyInstanceFromDatabase($options);
    }
}
