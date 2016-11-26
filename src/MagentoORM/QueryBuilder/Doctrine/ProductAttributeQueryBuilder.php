<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\QueryBuilder\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class ProductAttributeQueryBuilder implements ProductAttributeQueryBuilderInterface
{
    use AttributeQueryBuilderTrait;

    /**
     * @var string
     */
    private $variantAxisTable;

    /**
     * @var string
     */
    private $familyTable;

    /**
     * @param Connection $connection
     * @param string     $table
     * @param string     $extraTable
     * @param string     $entityTable
     * @param string     $variantAxisTable
     * @param string     $familyTable
     * @param array      $fields
     * @param array      $extraFields
     */
    public function __construct(
        Connection $connection,
        $table,
        $extraTable,
        $entityTable,
        $variantAxisTable,
        $familyTable,
        array $fields,
        array $extraFields
    ) {
        $this->connection = $connection;
        $this->table = $table;
        $this->extraTable = $extraTable;
        $this->variantAxisTable = $variantAxisTable;
        $this->entityTable = $entityTable;
        $this->familyTable = $familyTable;

        $this->fields = $fields;
        $this->extraFields = $extraFields;
    }

    /**
     * @return array
     */
    public static function getDefaultFields()
    {
        return [
            'attribute_id',
            'entity_type_id',
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
            'note',
        ];
    }

    /**
     * @return array
     */
    public static function getDefaultExtraFields()
    {
        return [
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
            'is_configurable', // exclusively M1
            'apply_to',
            'is_visible_in_advanced_search',
            'position',
            'is_wysiwyg_enabled',
            'is_used_for_promo_rules',
            'is_required_in_admin_store', // new since M2
            'is_used_in_grid', // new since M2
            'is_visible_in_grid', // new since M2
            'is_filterable_in_grid', // new since M2
            'search_weight', // new since M2
            'additional_data', // new since M2
        ];
    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    public static function getDefaultTable($prefix = null)
    {
        if ($prefix !== null) {
            return sprintf('%seav_attribute', $prefix);
        }

        return 'eav_attribute';
    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    public static function getDefaultEntityTable($prefix = null)
    {
        if ($prefix !== null) {
            return sprintf('%seav_entity_type', $prefix);
        }

        return 'eav_entity_type';
    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    public static function getDefaultExtraTable($prefix = null)
    {
        if ($prefix !== null) {
            return sprintf('%scatalog_eav_attribute', $prefix);
        }

        return 'catalog_eav_attribute';
    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    public static function getDefaultVariantTable($prefix = null)
    {
        if ($prefix !== null) {
            return sprintf('%scatalog_product_super_attribute', $prefix);
        }

        return 'catalog_product_super_attribute';
    }

    /**
     * @param string $prefix
     *
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
     * @param string $alias
     * @param string $extraAlias
     * @param string $entityAlias
     * @param string $variantAxisAlias
     *
     * @return QueryBuilder
     */
    public function createFindAllVariantAxisByEntityQueryBuilder($alias, $extraAlias, $entityAlias, $variantAxisAlias)
    {
        $queryBuilder = $this->createFindAllByEntityTypeQueryBuilder($alias, $extraAlias, $entityAlias);

        $queryBuilder->innerJoin($alias, $this->variantAxisTable, $variantAxisAlias,
            $queryBuilder->expr()->eq(sprintf('%s.attribute_id', $variantAxisAlias), sprintf('%s.attribute_id', $alias))
        );

        $queryBuilder->where($queryBuilder->expr()->eq(sprintf('%s.product_id', $variantAxisAlias), '?'));

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param string $extraAlias
     * @param string $entityAlias
     * @param string $familyAlias
     *
     * @return QueryBuilder
     */
    public function createFindAllByFamilyQueryBuilder($alias, $extraAlias, $entityAlias, $familyAlias)
    {
        $queryBuilder = $this->createFindAllByEntityTypeQueryBuilder($alias, $extraAlias, $entityAlias);

        $queryBuilder->innerJoin($alias, $this->familyTable, $familyAlias,
            $queryBuilder->expr()->eq(sprintf('%s.entity_type_id', $familyAlias), sprintf('%s.entity_type_id', $alias))
        );

        $queryBuilder->where($queryBuilder->expr()->eq(sprintf('%s.attribute_set_id', $familyAlias), '?'));

        return $queryBuilder;
    }

    /**
     * @param string $alias
     * @param string $extraAlias
     * @param string $entityAlias
     * @param string $familyAlias
     *
     * @return QueryBuilder
     */
    public function createFindAllMandatoryByFamilyQueryBuilder($alias, $extraAlias, $entityAlias, $familyAlias)
    {
        $queryBuilder = $this->createFindAllByEntityTypeQueryBuilder($alias, $extraAlias, $entityAlias);
        $queryBuilder->innerJoin($alias, $this->familyTable, $familyAlias,
            $queryBuilder->expr()->eq(sprintf('%s.entity_type_id', $familyAlias), sprintf('%s.entity_type_id', $alias))
        );
        $queryBuilder->where(sprintf('%s.attribute_set_id = ?', $familyAlias))
            ->andWhere(sprintf('%s.is_required = 1', $alias))
        ;

        return $queryBuilder;
    }
}