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

class ProductAttributeValueQueryBuilder implements ProductAttributeValueQueryBuilderInterface
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
    private $variantAxisTable;

    /**
     * @param Connection $connection
     * @param string     $table
     * @param string     $variantAxisTable
     * @param array      $fields
     */
    public function __construct(
        Connection $connection,
        $table,
        $variantAxisTable,
        array $fields
    ) {
        $this->connection = $connection;
        $this->table = $table;
        $this->variantAxisTable = $variantAxisTable;
        $this->fields = $fields;
    }

    /**
     * @return array
     */
    public static function getDefaultFields()
    {
        return [
            'value_id',
            'entity_type_id',
            'attribute_id',
            'store_id',
            'entity_id',
            'value',
        ];
    }

    /**
     * @param $backend
     * @param null $prefix
     *
     * @return string
     */
    public static function getDefaultTable($backend, $prefix = null)
    {
        return sprintf('%scatalog_product_entity_%s', $prefix, $backend);
    }

    /**
     * @param null $prefix
     *
     * @return string
     */
    public static function getDefaultVariantAxisTable($prefix = null)
    {
        return sprintf('%scatalog_product_super_attribute', $prefix);
    }

    /**
     * @param array  $fields
     * @param string $alias
     *
     * @return array
     */
    private function createFieldsList(array $fields, $alias)
    {
        $outputFields = [];
        foreach ($fields as $field) {
            $outputFields[] = sprintf('%s.%s', $alias, $field);
        }

        return $outputFields;
    }

    /**
     * @param array  $fields
     * @param string $defaultAlias
     * @param string $storeAlias
     *
     * @return array
     */
    private function createFallbackFieldsList(array $fields, $defaultAlias, $storeAlias)
    {
        $outputFields = [];
        foreach ($fields as $field) {
            $outputFields[] = sprintf('IFNULL(%2$s.%3$s, %1$s.%3$s) AS %3$s', $defaultAlias, $storeAlias, $field);
        }

        return $outputFields;
    }

    /**
     * @param string $alias
     * @param array  $fieldList
     *
     * @return QueryBuilder
     */
    private function createBaseQueryBuilder($alias, array $fieldList)
    {
        return (new QueryBuilder($this->connection))
            ->select($fieldList, $alias)
            ->from($this->table, $alias)
        ;
    }

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    private function createBaseQueryBuilderWithStoreFilter($alias)
    {
        $queryBuilder = $this->createBaseQueryBuilder($alias, $this->createFieldsList(['*'], $alias));

        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->eq(sprintf('%s.store_id', $alias), '?')
        );

        return $queryBuilder;
    }

    /**
     * @param string $defaultAlias
     * @param string $storeAlias
     *
     * @return QueryBuilder
     */
    private function createBaseQueryBuilderWithDefaultAndStoreFilter($defaultAlias, $storeAlias)
    {
        $queryBuilder = $this->createBaseQueryBuilder($defaultAlias, $this->createFallbackFieldsList($this->fields, $defaultAlias, $storeAlias));

        $queryBuilder
            ->leftJoin($defaultAlias, $this->table, $storeAlias, $queryBuilder->expr()->andX(
                $queryBuilder->expr()->eq(sprintf('%s.entity_id', $storeAlias), sprintf('%s.entity_id', $defaultAlias)),
                $queryBuilder->expr()->eq(sprintf('%s.attribute_id', $storeAlias), sprintf('%s.attribute_id', $defaultAlias)),
                $queryBuilder->expr()->eq(sprintf('%s.entity_type_id', $storeAlias), sprintf('%s.entity_type_id', $defaultAlias)),
                $queryBuilder->expr()->eq(sprintf('%s.store_id', $storeAlias), '?')
            ))
        ;

        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->eq(sprintf('%s.store_id', $defaultAlias), 0)
        );

        return $queryBuilder;
    }

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindQueryBuilder($alias)
    {
        return $this->createBaseQueryBuilder($alias, $this->createFieldsList($this->fields, $alias));
    }

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindAllFromStoreIdQueryBuilder($alias)
    {
        return $this->createBaseQueryBuilderWithStoreFilter($alias);
    }

    /**
     * @param string $defaultAlias
     * @param string $storeAlias
     *
     * @return QueryBuilder
     */
    public function createFindAllFromStoreIdOrDefaultQueryBuilder($defaultAlias, $storeAlias)
    {
        return $this->createBaseQueryBuilderWithDefaultAndStoreFilter($defaultAlias, $storeAlias);
    }

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindOneByIdQueryBuilder($alias)
    {
        $queryBuilder = $this->createBaseQueryBuilder($alias, $this->createFieldsList($this->fields, $alias));

        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->eq(sprintf('%s.value_id'), '?')
        );

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param array  $valueIds
     *
     * @return QueryBuilder
     */
    public function createFindAllByIdQueryBuilder($alias, array $valueIds)
    {
        $queryBuilder = $this->createBaseQueryBuilder($alias, $this->createFieldsList($this->fields, $alias));

        $expr = array_pad([], count($valueIds), $queryBuilder->expr()->eq(sprintf('%s.value_id', $alias), '?'));
        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->orX(...$expr)
        );

        return $queryBuilder;
    }

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindOneByProductIdAndAttributeIdFromStoreIdQueryBuilder($alias)
    {
        $queryBuilder = $this->createBaseQueryBuilderWithStoreFilter($alias);

        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->eq(sprintf('%s.entity_id', $alias), '?'),
            $queryBuilder->expr()->eq(sprintf('%s.attribute_id', $alias), '?')
        );

        return $queryBuilder;
    }

    /**
     * @param string $defaultAlias
     * @param string $storeAlias
     *
     * @return QueryBuilder
     */
    public function createFindOneByProductIdAndAttributeIdFromStoreIdOrDefaultQueryBuilder($defaultAlias, $storeAlias)
    {
        $queryBuilder = $this->createBaseQueryBuilderWithDefaultAndStoreFilter($defaultAlias, $storeAlias);

        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->eq(sprintf('%s.entity_id', $defaultAlias), '?'),
            $queryBuilder->expr()->eq(sprintf('%s.attribute_id', $defaultAlias), '?')
        );

        return $queryBuilder;
    }

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindAllByProductIdFromStoreIdQueryBuilder($alias)
    {
        $queryBuilder = $this->createBaseQueryBuilderWithStoreFilter($alias);

        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->eq(sprintf('%s.entity_id', $alias), '?')
        );

        return $queryBuilder;
    }

    /**
     * @param string $defaultAlias
     * @param string $storeAlias
     *
     * @return QueryBuilder
     */
    public function createFindAllByProductIdFromStoreIdOrDefaultQueryBuilder($defaultAlias, $storeAlias)
    {
        $queryBuilder = $this->createBaseQueryBuilderWithDefaultAndStoreFilter($defaultAlias, $storeAlias);

        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->eq(sprintf('%s.entity_id', $defaultAlias), '?')
        );

        return $queryBuilder;
    }

    /**
     * @param string $defaultAlias
     * @param string $variantAxisAlias
     *
     * @return QueryBuilder
     */
    public function createFindAllVariantAxisByProductIdFromStoreIdQueryBuilder($defaultAlias, $variantAxisAlias)
    {
        $queryBuilder = $this->createFindAllByProductIdFromStoreIdQueryBuilder($defaultAlias);

        $queryBuilder->innerJoin($defaultAlias, $this->variantAxisTable, $variantAxisAlias,
            $queryBuilder->expr()->eq(sprintf('%s.product_id', $variantAxisAlias), sprintf('%s.entity_id', $defaultAlias))
        );

        return $queryBuilder;
    }

    /**
     * @param string $defaultAlias
     * @param string $storeAlias
     * @param string $variantAxisAlias
     *
     * @return QueryBuilder
     */
    public function createFindAllVariantAxisByProductIdFromStoreIdOrDefaultQueryBuilder($defaultAlias, $storeAlias, $variantAxisAlias)
    {
        $queryBuilder = $this->createFindAllByProductIdFromStoreIdOrDefaultQueryBuilder($defaultAlias, $storeAlias);

        $queryBuilder->innerJoin($defaultAlias, $this->variantAxisTable, $variantAxisAlias,
            $queryBuilder->expr()->eq(sprintf('%s.product_id', $variantAxisAlias), sprintf('%s.entity_id', $defaultAlias))
        );

        return $queryBuilder;
    }

    /**
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createFindAllByProductIdQueryBuilder($alias)
    {
        $queryBuilder = $this->createBaseQueryBuilder($alias, $this->createFieldsList($this->fields, $alias));

        $this->andWhere(
            $queryBuilder,
            $queryBuilder->expr()->eq(sprintf('%s.entity_id', $alias), '?')
        );

        return $queryBuilder;
    }
}
