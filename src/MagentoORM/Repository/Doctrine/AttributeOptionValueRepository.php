<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoORM\Factory\AttributeOptionValueFactoryInterface;
use Kiboko\Component\MagentoORM\Model\AttributeOptionValueInterface;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\AttributeOptionValueQueryBuilderInterface;
use Kiboko\Component\MagentoORM\Repository\AttributeOptionValueRepositoryInterface;

class AttributeOptionValueRepository implements AttributeOptionValueRepositoryInterface
{
    /**
     * @var AttributeOptionValueQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var AttributeOptionValueFactoryInterface
     */
    private $attributeOptionValueFactory;

    /**
     * @param Connection                                $connection
     * @param AttributeOptionValueQueryBuilderInterface $queryBuilder
     * @param AttributeOptionValueFactoryInterface      $attributeOptionValueFactory
     */
    public function __construct(
        Connection $connection,
        AttributeOptionValueQueryBuilderInterface $queryBuilder,
        AttributeOptionValueFactoryInterface $attributeOptionValueFactory
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
        $this->attributeOptionValueFactory = $attributeOptionValueFactory;
    }

    /**
     * @param array $options
     *
     * @return AttributeOptionValueInterface
     */
    protected function createNewAttributeOptionValueInstanceFromDatabase(array $options)
    {
        return $this->attributeOptionValueFactory->buildNew($options);
    }

    /**
     * @param int $identifier
     *
     * @return AttributeOptionValueInterface
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

        return $this->createNewAttributeOptionValueInstanceFromDatabase($options);
    }
}
