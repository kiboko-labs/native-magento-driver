<?php

namespace Luni\Component\MagentoDriver\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Luni\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Luni\Component\MagentoDriver\Factory\AttributeOptionFactoryInterface;
use Luni\Component\MagentoDriver\Model\AttributeOptionInterface;
use Luni\Component\MagentoDriver\QueryBuilder\Doctrine\AttributeOptionQueryBuilderInterface;
use Luni\Component\MagentoDriver\Repository\AttributeOptionRepositoryInterface;

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
     * @param int $id
     *
     * @return AttributeOptionInterface
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

        return $this->createNewAttributeOptionInstanceFromDatabase($options);
    }

}
