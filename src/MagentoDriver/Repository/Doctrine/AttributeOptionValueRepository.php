<?php

namespace Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Luni\Component\MagentoDriver\Factory\AttributeOptionValueFactoryInterface;
use Luni\Component\MagentoDriver\Model\AttributeOptionValueInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\AttributeOptionValueQueryBuilderInterface;
use Luni\Component\MagentoDriver\Repository\AttributeOptionValueRepositoryInterface;

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
     * @param int $id
     *
     * @return AttributeOptionValueInterface
     */
    public function findOneById($id)
    {
        $query = $this->queryBuilder->createFindOneByIdQueryBuilder('eav_o');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$id])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $options = $statement->fetch();

        return $this->createNewAttributeOptionValueInstanceFromDatabase($options);
    }
}
