<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory\Magento19;

use Kiboko\Component\MagentoORM\Factory\CatalogAttributeExtensionsFactoryInterface;
use Kiboko\Component\MagentoORM\Model\CatalogAttributeExtensionInterface;
use Kiboko\Component\MagentoORM\Model\Magento19\CatalogAttributeExtension;

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
            $this->readBoolean($options, 'is_global', true),
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
            $this->readBoolean($options, 'is_configurable', false),
            $this->readBoolean($options, 'is_visible_in_advanced_search', false),
            $this->readBoolean($options, 'is_wysiwyg_enabled', false),
            $this->readBoolean($options, 'is_used_for_promo_rules', false),
            $this->readArray($options, 'apply_to', ',', []),
            $this->readBoolean($options, $options, 'position', 1),
            $this->readString($options, 'note', null)
        );
    }

    private function readInteger($options, $key, $default = null)
    {
        return (int) (isset($options[$key]) ? $options[$key] : $default);
    }

    private function readString($options, $key, $default = null)
    {
        return (string) (isset($options[$key]) ? $options[$key] : $default);
    }

    private function readBoolean($options, $key, $default = null)
    {
        return (bool) (isset($options[$key]) ? $options[$key] : $default);
    }

    private function readArray($options, $key, $default = null)
    {
        return isset($options[$key]) ? explode(',', $options[$key]) : $default;
    }
}
