<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\QueryBuilder\V1_9ce\Doctrine;

use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\AbstractProductAttributeQueryBuilder;
use Kiboko\Component\MagentoORM\QueryBuilder\Doctrine\AttributeQueryBuilder;

class ProductAttributeQueryBuilder extends AbstractProductAttributeQueryBuilder
{
    /**
     * @return array
     */
    public static function getDefaultFields()
    {
        return AttributeQueryBuilder::getDefaultFields();
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
        return AttributeQueryBuilder::getDefaultTable($prefix);
    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    public static function getDefaultEntityTable($prefix = null)
    {
        return AttributeQueryBuilder::getDefaultEntityTable($prefix);
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
