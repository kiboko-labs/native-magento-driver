<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model\Magento19;

use Kiboko\Component\MagentoORM\Model\AbstractCatalogAttributeExtension;

class CatalogAttributeExtension extends AbstractCatalogAttributeExtension implements CatalogAttributeExtensionInterface
{
    /**
     * @var bool
     */
    private $configurable;

    /**
     * AbstractCatalogAttributeExtension constructor.
     *
     * @param int $attributeId
     * @param string $frontendInputRendererClassName
     * @param bool $global
     * @param bool $visible
     * @param bool $searchable
     * @param bool $filterable
     * @param bool $comparable
     * @param bool $visibleOnFront
     * @param bool $htmlAllowedOnFront
     * @param bool $usedForPriceRules
     * @param bool $filterableInSearch
     * @param bool $usedInProductListing
     * @param bool $usedForSortBy
     * @param bool $visibleInAdvancedSearch
     * @param bool $wysiwygEnabled
     * @param bool $isConfigurable
     * @param bool $usedForPromoRules
     * @param string $note
     * @param int $position
     * @param array $productTypesApplyingTo
     */
    public function __construct(
        $attributeId,
        $frontendInputRendererClassName,
        $global = true,
        $visible = true,
        $searchable = false,
        $filterable = false,
        $comparable = false,
        $visibleOnFront = false,
        $htmlAllowedOnFront = false,
        $usedForPriceRules = false,
        $filterableInSearch = false,
        $usedInProductListing = false,
        $usedForSortBy = false,
        $visibleInAdvancedSearch = false,
        $wysiwygEnabled = false,
        $usedForPromoRules = false,
        $isConfigurable = false,
        array $productTypesApplyingTo = [],
        $note = null,
        $position = 1000
    ) {
        parent::__construct(
            $attributeId,
            $frontendInputRendererClassName,
            $global,
            $visible,
            $searchable,
            $filterable,
            $comparable,
            $visibleOnFront,
            $htmlAllowedOnFront,
            $usedForPriceRules,
            $filterableInSearch,
            $usedInProductListing,
            $usedForSortBy,
            $visibleInAdvancedSearch,
            $wysiwygEnabled,
            $usedForPromoRules,
            $productTypesApplyingTo,
            $note,
            $position
        );

        $this->configurable = $isConfigurable;
    }

    /**
     * @return bool
     */
    public function isConfigurable()
    {
        return $this->configurable;
    }
}
