<?php

namespace Luni\Component\MagentoDriver\QueryBuilder\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class ProductQueryBuilder
    implements ProductQueryBuilderInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var array
     */
    private $fields;

    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $familyTable;

    /**
     * @var string
     */
    private $productCategoryTable;

    /**
     * @param Connection $connection
     * @param string $table
     * @param string $familyTable
     * @param string $productCategoryTable
     * @param array $fields
     */
    public function __construct(
        Connection $connection,
        $table,
        $familyTable,
        $productCategoryTable,
        array $fields
    ) {
        $this->connection = $connection;
        $this->table = $table;
        $this->familyTable = $familyTable;
        $this->productCategoryTable = $productCategoryTable;

        $this->fields = $fields;
    }

    /**
     * @param array $fields
     * @param string $alias
     * @return array
     */
    protected function createFieldsList(array $fields, $alias)
    {
        $outputFields = [];
        foreach ($fields as $field) {
            $outputFields[] = sprintf('%s.%s', $alias, $field);
        }

        return $outputFields;
    }

    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createQueryBuilder($alias)
    {
        return (new QueryBuilder($this->connection))
            ->select($this->createFieldsList($this->fields, $alias))
            ->from($this->table, $alias)
        ;
    }

    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createFindAllQueryBuilder($alias)
    {
        $queryBuilder = $this->createQueryBuilder($alias)
            ->where(sprintf('%s.entity_type_id=4', $alias))
        ;

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createFindOneByIdentifierQueryBuilder($alias)
    {
        return $this->createFindAllQueryBuilder($alias)
            ->where(sprintf('%s.sku = ?', $alias), ':sku')
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;
    }

    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createFindOneByIdQueryBuilder($alias)
    {
        return $this->createFindAllQueryBuilder($alias)
            ->where(sprintf('%s.entity_id = ?', $alias), ':product_id')
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;
    }

    /**
     * @param string $alias
     * @param array|string[] $identifierList
     * @return QueryBuilder
     */
    public function createFindAllByIdentifierQueryBuilder($alias, array $identifierList)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $expr = array_pad([], count($identifierList), $queryBuilder->expr()->eq(sprintf('%s.sku', $alias), '?'));
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param array|int[] $idList
     * @return QueryBuilder
     */
    public function createFindAllByIdQueryBuilder($alias, array $idList)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $expr = array_pad([], count($idList), $queryBuilder->expr()->eq(sprintf('%s.entity_id', $alias), '?'));
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param string $familyAlias
     * @return QueryBuilder
     */
    public function createFindAllByFamilyQueryBuilder($alias, $familyAlias)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias)
            ->innerJoin($alias, $this->familyTable, $familyAlias,
                sprintf('%1$s.entity_type_id=%2$s.entity_type_id', $familyAlias, $alias))
            ->where(sprintf('%s.attribute_set_id = ?', $familyAlias))
        ;

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param string $categoryAlias
     * @return QueryBuilder
     */
    public function createFindAllByCategoryQueryBuilder($alias, $categoryAlias)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias)
            ->innerJoin($alias, $this->productCategoryTable, $categoryAlias,
                sprintf('%1$s.product_id=%2$s.entity_id', $categoryAlias, $alias))
            ->where(sprintf('%s.category_id = ?', $categoryAlias), ':category_id')
        ;

        return $queryBuilder;
    }
}