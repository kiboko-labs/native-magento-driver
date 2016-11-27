<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister\FlatFile\Magento20\Attribute;

use Kiboko\Component\MagentoORM\Exception\InvalidArgumentException;
use Kiboko\Component\MagentoORM\Model\CatalogAttributeExtensionInterface as BaseCatalogAttributeExtensionInterface;
use Kiboko\Component\MagentoORM\Model\Magento20\CatalogAttributeExtensionInterface;
use Kiboko\Component\MagentoORM\Persister\CatalogAttributeExtensionPersisterInterface;
use Kiboko\Component\MagentoORM\Persister\FlatFile\Attribute\CatalogAttributeExtensionPersisterTrait;

class CatalogAttributeExtensionPersister implements CatalogAttributeExtensionPersisterInterface
{
    use CatalogAttributeExtensionPersisterTrait;

    /**
     * @param BaseCatalogAttributeExtensionInterface $attributeExtension
     *
     * @return array
     */
    public function persist(BaseCatalogAttributeExtensionInterface $attributeExtension)
    {
        if (!$attributeExtension instanceof CatalogAttributeExtensionInterface) {
            throw new InvalidArgumentException(sprintf(
                'Invalid attribute extension type, expected "%s", got "%s".',
                BaseCatalogAttributeExtensionInterface::class,
                is_object($attributeExtension) ? get_class($attributeExtension) : gettype($attributeExtension)
            ));
        }

        $this->temporaryWriter->persistRow([
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
            'is_required_in_admin_store' => (int) $attributeExtension->isRequiredInAdminStore(),
            'is_used_in_grid' => (int) $attributeExtension->isUsedInGrid(),
            'is_visible_in_grid' => (int) $attributeExtension->isVisibleInGrid(),
            'is_filterable_in_grid' => (int) $attributeExtension->isFilterableInGrid(),
            'search_weight' => (int) $attributeExtension->getSearchWeight(),
            'additional_data' => empty($attributeExtension->getAdditionalData()) ?
                null : serialize($attributeExtension->getAdditionalData()),
        ]);
    }
}
