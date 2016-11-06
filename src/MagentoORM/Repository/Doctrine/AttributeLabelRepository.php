<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoORM\Factory\AttributeLabelFactoryInterface;
use Kiboko\Component\MagentoORM\Model\AttributeLabelInterface;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\AttributeLabelQueryBuilderInterface;
use Kiboko\Component\MagentoORM\Repository\AttributeLabelRepositoryInterface;

class AttributeLabelRepository implements AttributeLabelRepositoryInterface
{
    /**
     * @var AttributeLabelQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var AttributeLabelFactoryInterface
     */
    private $attributeLabelFactory;

    /**
     * @param Connection                          $connection
     * @param AttributeLabelQueryBuilderInterface $queryBuilder
     * @param AttributeLabelFactoryInterface      $attributeLabelFactory
     */
    public function __construct(
        Connection $connection,
        AttributeLabelQueryBuilderInterface $queryBuilder,
        AttributeLabelFactoryInterface $attributeLabelFactory
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
        $this->attributeLabelFactory = $attributeLabelFactory;
    }

    /**
     * @param array $options
     *
     * @return AttributeLabelInterface
     */
    protected function createNewAttributeLabelInstanceFromDatabase(array $options)
    {
        return $this->attributeLabelFactory->buildNew($options);
    }

    /**
     * @param int $identifier
     *
     * @return AttributeLabelInterface
     */
    public function findOneById($identifier)
    {
        $query = $this->queryBuilder->createFindOneByIdQueryBuilder('eav_l');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$identifier])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewAttributeLabelInstanceFromDatabase($options);
    }
}
