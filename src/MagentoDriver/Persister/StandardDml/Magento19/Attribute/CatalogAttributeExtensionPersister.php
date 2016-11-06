<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Persister\StandardDml\Magento19\Attribute;

use Kiboko\Component\MagentoDriver\Exception\InvalidArgumentException;
use Kiboko\Component\MagentoDriver\Model\CatalogAttributeExtensionInterface as BaseCatalogAttributeExtensionInterface;
use Kiboko\Component\MagentoDriver\Model\Magento19\CatalogAttributeExtensionInterface;
use Kiboko\Component\MagentoDriver\Persister\CatalogAttributeExtensionPersisterInterface;
use Kiboko\Component\MagentoDriver\Persister\StandardDml\Attribute\CatalogAttributeExtensionPersisterTrait;

class CatalogAttributeExtensionPersister implements CatalogAttributeExtensionPersisterInterface
{
    use CatalogAttributeExtensionPersisterTrait;

    /**
     * @param BaseCatalogAttributeExtensionInterface $attributeExtension
     * @return array
     */
    protected function getInsertData(BaseCatalogAttributeExtensionInterface $attributeExtension)
    {
        if (!$attributeExtension instanceof CatalogAttributeExtensionInterface) {
            throw new InvalidArgumentException(sprintf(
                'Invalid attribute extension type, expected "%s", got "%s".',
                BaseCatalogAttributeExtensionInterface::class,
                is_object($attributeExtension) ? get_class($attributeExtension) : gettype($attributeExtension)
            ));
        }

        return [
            'attribute_id' => $attributeExtension->getId(),
            'frontend_input_renderer' => $attributeExtension->getFrontendInputRendererClassName(),
            'is_global' => $attributeExtension->isGlobal(),
            'is_visible' => $attributeExtension->isVisible(),
            'is_searchable' => (int) $attributeExtension->isSearchable(),
            'is_filterable' => (int) $attributeExtension->isFilterable(),
            'is_comparable' => (int) $attributeExtension->isComparable(),
            'is_visible_on_front' => (int) $attributeExtension->isVisibleOnFront(),
            'is_html_allowed_on_front' => (int) $attributeExtension->isHtmlAllowedOnFront(),
            'is_used_for_price_rules' => (int) $attributeExtension->isUsedForPriceRules(),
            'is_filterable_in_search' => (int) $attributeExtension->isFilterableInSearch(),
            'used_in_product_listing' => (int) $attributeExtension->isUsedInProductListing(),
            'used_for_sort_by' => (int) $attributeExtension->isUsedForSortBy(),
            'apply_to' => empty($attributeExtension->getProductTypesApplyingTo()) ?
                null : implode(',', $attributeExtension->getProductTypesApplyingTo()),
            'is_visible_in_advanced_search' => (int) $attributeExtension->isVisibleInAdvancedSearch(),
            'position' => $attributeExtension->getPosition(),
            'is_wysiwyg_enabled' => (int) $attributeExtension->isWysiwygEnabled(),
            'is_used_for_promo_rules' => (int) $attributeExtension->isUsedForPromoRules(),
            'is_configurable' => (int) $attributeExtension->isConfigurable(),
        ];
    }

    /**
     * @return array
     */
    protected function getUpdatedFields()
    {
        return [
            'attribute_id',
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
            'apply_to',
            'is_visible_in_advanced_search',
            'position',
            'is_wysiwyg_enabled',
            'is_used_for_promo_rules',
            'is_configurable',
        ];
    }

    /**
     * @return string
     */
    protected function getIdentifierField()
    {
        return 'attribute_id';
    }
}
