<?php

namespace Luni\Component\MagentoDriver\QueryBuilder\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

trait AttributeQueryBuilderTrait
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var array
     */
    private $fields = [
        'attribute_id',
        'attribute_code',
        'attribute_model',
        'backend_model',
        'backend_type',
        'backend_table',
        'frontend_model',
        'frontend_input',
        'frontend_label',
        'frontend_class',
        'source_model',
        'is_required',
        'is_user_defined',
        'default_value',
        'is_unique',
    ];

    /**
     * @var array
     */
    private $extraFields = [
        'frontend_input_renderer',
        'is_global',
        'is_visible',
        'is_searchable',
        'is_filterable',
        'is_comparable',
        'is_visible_on_front',
        'is_html_allowed_on_front',
        'is_used_for_price_rules',
        'is_filterable_in_search',
        'used_in_product_listing',
        'used_for_sort_by',
        'is_configurable',
        'apply_to',
        'is_visible_in_advanced_search',
        'position',
        'is_wysiwyg_enabled',
        'is_used_for_promo_rules',
    ];

    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $extraTable;

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
     * @param string $extraAlias
     * @return QueryBuilder
     */
    public function createFindAllQueryBuilder($alias, $extraAlias)
    {
        return $this->createQueryBuilder($alias)
            ->innerJoin($alias, $this->extraTable, $extraAlias,
                sprintf('%s.attribute_id=%s.attribute_id', $extraAlias, $alias))
            ->addSelect($this->createFieldsList($this->extraFields, $extraAlias))
            ->where(sprintf('%s.entity_type_id=4', $alias))
        ;
    }

    /**
     * @param string $alias
     * @param string $extraAlias
     * @return QueryBuilder
     */
    public function createFindOneByCodeQueryBuilder($alias, $extraAlias)
    {
        return $this->createFindAllQueryBuilder($alias, $extraAlias)
            ->where(sprintf('%s.attribute_code = ?', $alias))
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;
    }

    /**
     * @param string $alias
     * @param string $extraAlias
     * @return QueryBuilder
     */
    public function createFindOneByIdQueryBuilder($alias, $extraAlias)
    {
        return $this->createFindAllQueryBuilder($alias, $extraAlias)
            ->where(sprintf('%s.attribute_id = ?', $alias))
            ->setFirstResult(0)
            ->setMaxResults(1)
        ;
    }

    /**
     * @param string $alias
     * @param string $extraAlias
     * @param array|string[] $codeList
     * @return QueryBuilder
     */
    public function createFindAllByCodeQueryBuilder($alias, $extraAlias, array $codeList)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias, $extraAlias);

        $expr = array_pad([], count($codeList), $queryBuilder->expr()->eq(sprintf('%s.attribute_code', $alias), '?'));
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param string $extraAlias
     * @param array|int[] $idList
     * @return QueryBuilder
     */
    public function createFindAllByIdQueryBuilder($alias, $extraAlias, array $idList)
    {
        $queryBuilder = $this->createFindAllQueryBuilder($alias, $extraAlias);

        $expr = array_pad([], count($idList), $queryBuilder->expr()->eq(sprintf('%s.attribute_id', $alias), '?'));
        $queryBuilder->andWhere($queryBuilder->expr()->orX(...$expr));

        return $queryBuilder;
    }
}