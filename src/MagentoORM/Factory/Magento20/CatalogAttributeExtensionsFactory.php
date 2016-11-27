<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory\Magento20;

use Kiboko\Component\MagentoORM\Factory\CatalogAttributeExtensionsFactoryInterface;
use Kiboko\Component\MagentoORM\Model\CatalogAttributeExtensionInterface;
use Kiboko\Component\MagentoORM\Model\Magento20\CatalogAttributeExtension;

class CatalogAttributeExtensionsFactory implements CatalogAttributeExtensionsFactoryInterface
{
    /**
     * @param array $options
     *
     * @return CatalogAttributeExtensionInterface
     */
    public function buildNew(array $options)
    {
        return new CatalogAttributeExtension(
            $this->readInteger($options, 'attribute_id', null),
            $this->readString($options, 'frontend_input_renderer', null),
            $this->readInteger($options, 'is_global', CatalogAttributeExtensionInterface::SCOPE_GLOBAL),
            $this->readBoolean($options, 'is_visible', false),
            $this->readBoolean($options, 'is_searchable', false),
            $this->readBoolean($options, 'is_filterable', false),
            $this->readBoolean($options, 'is_comparable', false),
            $this->readBoolean($options, 'is_visible_on_front', false),
            $this->readBoolean($options, 'is_html_allowed_on_front', false),
            $this->readBoolean($options, 'is_used_for_price_rules', false),
            $this->readBoolean($options, 'is_filterable_in_search', false),
            $this->readBoolean($options, 'used_in_product_listing', false),
            $this->readBoolean($options, 'used_for_sort_by', false),
            $this->readBoolean($options, 'is_visible_in_advanced_search', false),
            $this->readBoolean($options, 'is_wysiwyg_enabled', false),
            $this->readBoolean($options, 'is_used_for_promo_rules', false),
            $this->readBoolean($options, 'is_required_in_admin_store', false),
            $this->readBoolean($options, 'is_used_in_grid', false),
            $this->readBoolean($options, 'is_visible_in_grid', false),
            $this->readBoolean($options, 'is_filterable_in_grid', false),
            $this->readBoolean($options, 'search_weight', 0),
            $this->readSerialized($options, 'additional_data', []),
            $this->readArray($options, 'apply_to', []),
            $this->readString($options, 'note', null),
            $this->readBoolean($options, 'position', 1)
        );
    }

    private function readInteger(array $options, $key, $default = null)
    {
        return (int) (isset($options[$key]) ? $options[$key] : $default);
    }

    private function readString(array $options, $key, $default = null)
    {
        return (string) (isset($options[$key]) ? $options[$key] : $default);
    }

    private function readBoolean(array $options, $key, $default = null)
    {
        return (bool) (isset($options[$key]) ? $options[$key] : $default);
    }

    private function readArray(array $options, $key, $default = null)
    {
        return isset($options[$key]) ? explode(',', $options[$key]) : $default;
    }

    private function readSerialized(array $options, $key, $default = null)
    {
        return isset($options[$key]) ? unserialize($options[$key]) : $default;
    }
}
