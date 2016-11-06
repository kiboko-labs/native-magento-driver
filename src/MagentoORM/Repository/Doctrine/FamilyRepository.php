<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoORM\Factory\FamilyFactoryInterface;
use Kiboko\Component\MagentoORM\Model\FamilyInterface;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\FamilyQueryBuilderInterface;
use Kiboko\Component\MagentoORM\Repository\FamilyRepositoryInterface;

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
     * @param int $identifier
     *
     * @return FamilyInterface
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
