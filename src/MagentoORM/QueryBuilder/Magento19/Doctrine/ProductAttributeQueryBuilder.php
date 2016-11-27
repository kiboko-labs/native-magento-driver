<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\QueryBuilder\Magento19\Doctrine;

use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\AbstractProductAttributeQueryBuilder;

class ProductAttributeQueryBuilder extends AbstractProductAttributeQueryBuilder
{
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
            'is_configurable',
            'apply_to',
            'is_visible_in_advanced_search',
            'position',
            'is_wysiwyg_enabled',
            'is_used_for_promo_rules',
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
}
