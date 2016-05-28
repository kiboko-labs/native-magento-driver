<?php

namespace Kiboko\Component\MagentoMapper\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoMapper\QueryBuilder\OptionQueryBuilderInterface;
use Kiboko\Component\MagentoMapper\Repository\OptionRepositoryInterface;

class OptionRepository implements OptionRepositoryInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var OptionQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * AttributeRepository constructor.
     *
     * @param Connection                  $connection
     * @param OptionQueryBuilderInterface $queryBuilder
     */
    public function __construct(
        Connection $connection,
        OptionQueryBuilderInterface $queryBuilder
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @param AttributeInterface $attribute
     * @param $optionCode
     *
     * @return null|int
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findOneByAttribute(AttributeInterface $attribute, $optionCode)
    {
        $query = $this->queryBuilder->createFindOneByAttributeQueryBuilder('o');

        $statement = $this->connection->prepare($query);
        $statement->bindValue(1, $optionCode);
        $statement->bindValue(2, $attribute->getId());

        if (!$statement->execute()) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $id = $statement->fetchColumn(0);
        if ($id === false) {
            return;
        }

        return $id;
    }

    /**
     * @param int $attributeId
     * @param $optionCode
     *
     * @return null|int
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findOneByAttributeId($attributeId, $optionCode)
    {
        $query = $this->queryBuilder->createFindOneByAttributeQueryBuilder('o');

        $statement = $this->connection->prepare($query);
        $statement->bindValue(1, $optionCode);
        $statement->bindValue(2, $attributeId);

        if (!$statement->execute()) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $id = $statement->fetchColumn(0);
        if ($id === false) {
            return;
        }

        return $id;
    }

    /**
     * @param string $attributeCode
     * @param $optionCode
     *
     * @return null|int
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findOneByAttributeCode($attributeCode, $optionCode)
    {
        $query = $this->queryBuilder->createFindOneByAttributeQueryBuilder('o');

        $statement = $this->connection->prepare($query);
        $statement->bindValue(1, $optionCode);
        $statement->bindValue(2, $attributeCode);

        if (!$statement->execute()) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return;
        }

        $id = $statement->fetchColumn(0);
        if ($id === false) {
            return;
        }

        return $id;
    }

    /**
     * @param AttributeInterface $attribute
     *
     * @return int[]
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findAllByAttribute(AttributeInterface $attribute)
    {
        $query = $this->queryBuilder->createFindAllByAttributeQueryBuilder('o');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute([$attribute->getId()])) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return [];
        }

        $attributeList = [];
        foreach ($statement as $options) {
            $attributeList[$options['option_code']] = $options['option_id'];
        }

        return $attributeList;
    }
}
