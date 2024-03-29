<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\QueryBuilder\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Kiboko\Component\MagentoORM\AndWhereDoctrineFixForPHP7;

class ProductQueryBuilder implements ProductQueryBuilderInterface
{
    use AndWhereDoctrineFixForPHP7;

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
     * @param string     $table
     * @param string     $familyTable
     * @param string     $categoryProductTable
     * @param array      $fields
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
     * @param string|null $version
     *
     * @return array
     */
    public static function getDefaultFields($version = null)
    {
        if ($version !== null) {
            if (version_compare($version, '2.0', '>=')) {
                return [
                    'entity_id',
                    'attribute_set_id',
                    'type_id',
                    'sku',
                    'has_options',
                    'required_options',
                    'created_at',
                    'updated_at',
                ];
            }
        }

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
     *
     * @return string $prefix.'catalog_product_entity'
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
     *
     * @return string $prefix.'eav_attribute_set'
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
     *
     * @return string $prefix.'catalog_category_product'
     */
    public static function getDefaultCategoryProductTable($prefix = null)
    {
        if ($prefix !== null) {
            return sprintf('%scatalog_category_product', $prefix);
        }

        return 'catalog_category_product';
    }

    /**
     * @param array  $fields
     * @param string $alias
     *
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
     *
     * @return QueryBuilder
     */
    public function createFindQueryBuilder($alias)
    {
        return (new QueryBuilder($this->connection))
            ->select($this->createFieldsList(['*'], $alias))
            ->from($this->table, $alias)
        ;
    }

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindAllQueryBuilder($alias)
    {
        $queryBuilder = $this->createFindQueryBuilder($alias);

        return $queryBuilder;
    }

    /**
     * @return QueryBuilder
     */
    public function createDeleteQueryBuilder()
    {
        return (new QueryBuilder($this->connection))
            ->delete($this->table)
        ;
    }

    /**
     * @param string $alias
     *
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
     *
     * @return QueryBuilder
     */
    public function createFindOneByIdQueryBuilder($alias)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $queryBuilder->where($queryBuilder->expr()->eq(sprintf('%s.entity_id', $alias), '?'))
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;

        return $queryBuilder;
    }

    /**
     * @param string         $alias
     * @param array|string[] $identifierList
     *
     * @return QueryBuilder
     */
    public function createFindAllByIdentifierQueryBuilder($alias, array $identifierList)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $expr = array_pad([], count($identifierList), $queryBuilder->expr()->eq(sprintf('%s.sku', $alias), '?'));
        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->orX(...$expr)
        );

        return $queryBuilder;
    }

    /**
     * @param string      $alias
     * @param array|int[] $idList
     *
     * @return QueryBuilder
     */
    public function createFindAllByIdQueryBuilder($alias, array $idList)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $expr = array_pad([], count($idList), $queryBuilder->expr()->eq(sprintf('%s.entity_id', $alias), '?'));
        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->orX(...$expr)
        );

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param string $familyAlias
     *
     * @return QueryBuilder
     */
    public function createFindAllByFamilyQueryBuilder($alias, $familyAlias)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $queryBuilder->innerJoin($alias, $this->familyTable, $familyAlias,
            $queryBuilder->expr()->andX(
                $queryBuilder->expr()->eq(sprintf('%s.attribute_set_id', $alias), sprintf('%s.attribute_set_id', $familyAlias))
            )
        );

        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->eq(sprintf('%s.attribute_set_id', $familyAlias), '?')
        );

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param string $categoryAlias
     *
     * @return QueryBuilder
     */
    public function createFindAllByCategoryQueryBuilder($alias, $categoryAlias)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias);

        $queryBuilder->innerJoin($alias, $this->categoryProductTable, $categoryAlias,
            $queryBuilder->expr()->eq(sprintf('%s.product_id', $categoryAlias), sprintf('%s.entity_id', $alias))
        );

        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->eq(sprintf('%s.category_id', $categoryAlias), '?')
        );

        return $queryBuilder;
    }

    /**
     * @return QueryBuilder
     */
    public function createDeleteOneByIdQueryBuilder()
    {
        $queryBuilder = $this->createDeleteQueryBuilder();

        $queryBuilder->where($queryBuilder->expr()->eq('entity_id', '?'))
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;

        return $queryBuilder;
    }

    /**
     * @param array $idList
     *
     * @return QueryBuilder
     */
    public function createDeleteAllByIdQueryBuilder(array $idList)
    {
        $queryBuilder = $this->createDeleteQueryBuilder();

        $expr = array_pad([], count($idList), $queryBuilder->expr()->eq('entity_id', '?'));
        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->orX(...$expr)
        );

        return $queryBuilder;
    }

    /**
     * @return QueryBuilder
     */
    public function createDeleteOneByIdentifierQueryBuilder()
    {
        $queryBuilder = $this->createDeleteQueryBuilder();

        $queryBuilder->where($queryBuilder->expr()->eq('sku', '?'))
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;

        return $queryBuilder;
    }

    /**
     * @param array $skuList
     *
     * @return QueryBuilder
     */
    public function createDeleteAllByIdentitiferQueryBuilder(array $skuList)
    {
        $queryBuilder = $this->createDeleteQueryBuilder();

        $expr = array_pad([], count($skuList), $queryBuilder->expr()->eq('sku', '?'));
        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->orX(...$expr)
        );

        return $queryBuilder;
    }
}
