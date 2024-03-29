<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoORM\Factory\AttributeOptionFactoryInterface;
use Kiboko\Component\MagentoORM\Model\AttributeOptionInterface;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\AttributeOptionQueryBuilderInterface;
use Kiboko\Component\MagentoORM\Repository\AttributeOptionRepositoryInterface;

class AttributeOptionRepository implements AttributeOptionRepositoryInterface
{
    /**
     * @var AttributeOptionQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var AttributeOptionFactoryInterface
     */
    private $attributeOptionFactory;

    /**
     * @param Connection                           $connection
     * @param AttributeOptionQueryBuilderInterface $queryBuilder
     * @param AttributeOptionFactoryInterface      $attributeOptionFactory
     */
    public function __construct(
        Connection $connection,
        AttributeOptionQueryBuilderInterface $queryBuilder,
        AttributeOptionFactoryInterface $attributeOptionFactory
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
        $this->attributeOptionFactory = $attributeOptionFactory;
    }

    /**
     * @param array $options
     *
     * @return AttributeOptionInterface
     */
    protected function createNewAttributeOptionInstanceFromDatabase(array $options)
    {
        return $this->attributeOptionFactory->buildNew($options);
    }

    /**
     * @param int $identifier
     *
     * @return AttributeOptionInterface
     */
    public function findOneById($identifier)
    {
        $query = $this->queryBuilder->createFindOneByIdQueryBuilder('eav_o');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$identifier])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewAttributeOptionInstanceFromDatabase($options);
    }
}
