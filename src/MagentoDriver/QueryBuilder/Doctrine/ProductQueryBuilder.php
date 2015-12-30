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
    private $categoryProductTable;

    /**
     * @param Connection $connection
     * @param string $table
     * @param string $familyTable
     * @param string $categoryProductTable
     * @param array $fields
     */
    public function __construct(
        Connection $connection,
        $table,
        $familyTable,
        $categoryProductTable,
        array $fields
    ) {
        $this->connection = $connection;
        $this->table = $table;
        $this->familyTable = $familyTable;
        $this->categoryProductTable = $categoryProductTable;

        $this->fields = $fields;
    }

    /**
     * @return array
     */
    public static function getDefaultFields()
    {
        return [
            'entity_id',
            'entity_type_id',
            'attribute_set_id',
            'type_id',
            'sku',
            'has_options',
            'required_options',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * @param string $prefix
     * @return string
     */
    public static function getDefaultTable($prefix = null)
    {
        if ($prefix !== null) {
            return sprintf('%scatalog_product_entity', $prefix);
        }

        return 'catalog_product_entity';
    }

    /**
     * @param string $prefix
     * @return string
     */
    public static function getDefaultFamilyTable($prefix = null)
    {
        if ($prefix !== null) {
            return sprintf('%seav_attribute_set', $prefix);
        }

        return 'eav_attribute_set';
    }

    /**
     * @param string $prefix
     * @return string
     */
    public static function getDefaultCategoryProductTable($prefix = null)
    {
        if ($prefix !== null) {
            return sprintf('%scatalog_category_product', $prefix);
        }

        return 'catalog_category_product';
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
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $queryBuilder->where($queryBuilder->expr()->eq(sprintf('%s.sku', $alias), '?'))
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createFindOneByIdQueryBuilder($alias)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $queryBuilder->where($queryBuilder->expr()->eq(sprintf('%s.entity_id', $alias), '?'))
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;

        echo $queryBuilder->getSQL();
        return $queryBuilder;
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
        ;

        $queryBuilder->andWhere($queryBuilder->expr()->eq(sprintf('%s.attribute_set_id', $familyAlias), '?'));

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
            ->innerJoin($alias, $this->categoryProductTable, $categoryAlias,
                sprintf('%1$s.product_id=%2$s.entity_id', $categoryAlias, $alias))
        ;

        $queryBuilder->andWhere($queryBuilder->expr()->eq(sprintf('%s.category_id', $categoryAlias), '?'));

        return $queryBuilder;
    }
}