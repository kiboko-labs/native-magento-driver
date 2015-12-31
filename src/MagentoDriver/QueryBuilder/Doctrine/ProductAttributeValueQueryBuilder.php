<?php

namespace Luni\Component\MagentoDriver\QueryBuilder\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class ProductAttributeValueQueryBuilder
    implements ProductAttributeValueQueryBuilderInterface
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
    private $variantAxisTable;

    /**
     * @param Connection $connection
     * @param string $table
     * @param string $variantAxisTable
     * @param array $fields
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
     * @return string
     */
    public static function getDefaultTable($backend, $prefix = null)
    {
        return sprintf('%scatalog_product_entity_%s', $prefix, $backend);
    }

    /**
     * @param null $prefix
     * @return string
     */
    public static function getDefaultVariantAxisTable($prefix = null)
    {
        return sprintf('%scatalog_product_super_attribute', $prefix);
    }

    /**
     * @param array $fields
     * @param string $alias
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
     * @param array $fields
     * @param string $defaultAlias
     * @param string $storeAlias
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
     * @param array $fieldList
     * @return QueryBuilder
     */
    private function createBaseQueryBuilder($alias, array $fieldList)
    {
        return (new QueryBuilder($this->connection))
            ->select($fieldList, $alias)
            ->from($this->table, $alias)
            ->where(sprintf('%s.entity_type_id=4', $alias))
        ;
    }

    /**
     * @param string $alias
     * @return QueryBuilder
     */
    private function createBaseQueryBuilderWithStoreFilter($alias)
    {
        $queryBuilder = $this->createBaseQueryBuilder($alias, $this->createFieldsList($this->fields, $alias));

        $queryBuilder->andWhere($queryBuilder->expr()->eq(sprintf('%s.store_id', $alias), '?'));

        return $queryBuilder;
    }

    /**
     * @param string $defaultAlias
     * @param string $storeAlias
     * @return QueryBuilder
     */
    private function createBaseQueryBuilderWithDefaultAndStoreFilter($defaultAlias, $storeAlias)
    {
        $queryBuilder = $this->createBaseQueryBuilder($defaultAlias, $this->createFallbackFieldsList($this->fields, $defaultAlias, $storeAlias))
            ->innerJoin($defaultAlias, $this->table, $storeAlias,
                sprintf('%1$s.entity_id=%2$s.entity_id AND %1$s.attribute_id=%2$s.attribute_id', $storeAlias, $defaultAlias))
            ->where(sprintf('%s.entity_type_id=4', $storeAlias))
        ;

        $queryBuilder->andWhere($queryBuilder->expr()->eq(sprintf('%s.store_id', $defaultAlias), 0));
        $queryBuilder->andWhere($queryBuilder->expr()->eq(sprintf('%s.store_id', $storeAlias), '?'));

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createQueryBuilder($alias)
    {
        return $this->createBaseQueryBuilder($alias, $this->createFieldsList($this->fields, $alias));
    }

    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createFindAllFromStoreIdQueryBuilder($alias)
    {
        return $this->createBaseQueryBuilderWithStoreFilter($alias);
    }

    /**
     * @param string $defaultAlias
     * @param string $storeAlias
     * @return QueryBuilder
     */
    public function createFindAllFromStoreIdOrDefaultQueryBuilder($defaultAlias, $storeAlias)
    {
        return $this->createBaseQueryBuilderWithDefaultAndStoreFilter($defaultAlias, $storeAlias);
    }

    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createFindOneByIdQueryBuilder($alias)
    {
        $queryBuilder = $this->createBaseQueryBuilder($alias, $this->createFieldsList($this->fields, $alias));

        $queryBuilder->andWhere($queryBuilder->expr()->eq(sprintf('%s.value_id'), '?'));

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param array $valueIds
     * @return QueryBuilder
     */
    public function createFindAllByIdQueryBuilder($alias, array $valueIds)
    {
        $queryBuilder = $this->createBaseQueryBuilder($alias, $this->createFieldsList($this->fields, $alias));

        $expr = array_pad([], count($valueIds), $queryBuilder->expr()->eq(sprintf('%s.value_id', $alias), '?'));
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createFindOneByProductIdAndAttributeIdFromStoreIdQueryBuilder($alias)
    {
        $queryBuilder = $this->createBaseQueryBuilderWithStoreFilter($alias);

        $queryBuilder->andWhere($queryBuilder->expr()->eq(sprintf('%s.entity_id', $alias), '?'));
        $queryBuilder->andWhere($queryBuilder->expr()->eq(sprintf('%s.attribute_id', $alias), '?'));

        return $queryBuilder;
    }

    /**
     * @param string $defaultAlias
     * @param string $storeAlias
     * @return QueryBuilder
     */
    public function createFindOneByProductIdAndAttributeIdFromStoreIdOrDefaultQueryBuilder($defaultAlias, $storeAlias)
    {
        $queryBuilder = $this->createBaseQueryBuilderWithDefaultAndStoreFilter($defaultAlias, $storeAlias);

        $queryBuilder->andWhere($queryBuilder->expr()->eq(sprintf('%s.entity_id', $defaultAlias), '?'));
        $queryBuilder->andWhere($queryBuilder->expr()->eq(sprintf('%s.attribute_id', $defaultAlias), '?'));

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createFindAllByProductIdFromStoreIdQueryBuilder($alias)
    {
        $queryBuilder = $this->createBaseQueryBuilderWithStoreFilter($alias);

        $queryBuilder->andWhere($queryBuilder->expr()->eq(sprintf('%s.entity_id', $alias), '?'));

        return $queryBuilder;
    }

    /**
     * @param string $defaultAlias
     * @param string $storeAlias
     * @return QueryBuilder
     */
    public function createFindAllByProductIdFromStoreIdOrDefaultQueryBuilder($defaultAlias, $storeAlias)
    {
        $queryBuilder = $this->createBaseQueryBuilderWithDefaultAndStoreFilter($defaultAlias, $storeAlias);

        $queryBuilder->andWhere($queryBuilder->expr()->eq(sprintf('%s.entity_id', $defaultAlias), '?'));

        return $queryBuilder;
    }

    /**
     * @param string $defaultAlias
     * @param string $variantAxisAlias
     * @return QueryBuilder
     */
    public function createFindAllVariantAxisByProductFromStoreIdQueryBuilder($defaultAlias, $variantAxisAlias)
    {
        $queryBuilder = $this->createFindAllByProductIdFromStoreIdQueryBuilder($defaultAlias)
            ->innerJoin($defaultAlias, $this->variantAxisTable, $variantAxisAlias,
                sprintf('%s.product_id=%s.entity_id', $variantAxisAlias, $defaultAlias))
        ;

        return $queryBuilder;
    }

    /**
     * @param string $defaultAlias
     * @param string $storeAlias
     * @param string $variantAxisAlias
     * @return QueryBuilder
     */
    public function createFindAllVariantAxisByProductFromStoreIdOrDefaultQueryBuilder($defaultAlias, $storeAlias, $variantAxisAlias)
    {
        $queryBuilder = $this->createFindAllByProductIdFromStoreIdOrDefaultQueryBuilder($defaultAlias, $storeAlias)
            ->innerJoin($defaultAlias, $this->variantAxisTable, $variantAxisAlias,
                sprintf('%s.product_id=%s.entity_id', $variantAxisAlias, $defaultAlias))
        ;

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @return QueryBuilder
     */
    public function createFindAllByProductIdQueryBuilder($alias)
    {
        $queryBuilder = $this->createBaseQueryBuilder($alias, $this->createFieldsList($this->fields, $alias));

        $queryBuilder->andWhere($queryBuilder->expr()->eq(sprintf('%s.entity_id', $alias), '?'));

        return $queryBuilder;
    }
}