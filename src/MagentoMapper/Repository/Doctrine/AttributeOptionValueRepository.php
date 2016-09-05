<?php

namespace Kiboko\Component\MagentoMapper\Repository\Doctrine;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoDriver\Exception\DatabaseFetchingFailureException;
use Kiboko\Component\MagentoMapper\QueryBuilder\AttributeOptionValueQueryBuilderInterface;
use Kiboko\Component\MagentoMapper\Repository\AttributeOptionValueRepositoryInterface;

class AttributeOptionValueRepository implements AttributeOptionValueRepositoryInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var AttributeOptionValueQueryBuilderInterface
     */
    private $queryBuilder;

    /**
     * AttributeRepository constructor.
     *
     * @param Connection                                $connection
     * @param AttributeOptionValueQueryBuilderInterface $queryBuilder
     */
    public function __construct(
        Connection $connection,
        AttributeOptionValueQueryBuilderInterface $queryBuilder
    ) {
        $this->connection = $connection;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @param string $code
     * @param string $locale
     *
     * @return null|int
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findOneByCodeAndLocale($code, $locale)
    {
        $query = $this->queryBuilder->createFindOneByCodeAndLocaleQueryBuilder('p');

        $statement = $this->connection->prepare($query);
        $statement->bindValue(1, $code);
        $statement->bindValue(2, $locale);

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
     * @return int[]
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findAll()
    {
        $query = $this->queryBuilder->createFindAllQueryBuilder('p');

        $statement = $this->connection->prepare($query);
        if (!$statement->execute()) {
            throw new DatabaseFetchingFailureException();
        }

        if ($statement->rowCount() < 1) {
            return [];
        }

        $attributeList = [];
        foreach ($statement as $options) {
            if (!isset($attributeList[$options['option_code']][$options['locale']])) {
                $attributeList[$options['option_code']][$options['locale']] = [];
            }

            $attributeList[$options['option_code']][$options['locale']] = $options['option_id'];
        }

        return $attributeList;
    }
}
