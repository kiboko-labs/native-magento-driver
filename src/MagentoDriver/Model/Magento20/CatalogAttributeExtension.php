<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model\Magento20;

use Kiboko\Component\MagentoDriver\Model\AbstractCatalogAttributeExtension;

class CatalogAttributeExtension extends AbstractCatalogAttributeExtension implements CatalogAttributeExtensionInterface
{
    /**
     * @var int
     */
    private $requiredInAdminStore;

    /**
     * @var int
     */
    private $usedInGrid;

    /**
     * @var int
     */
    private $visibleInGrid;

    /**
     * @var int
     */
    private $filterableInGrid;

    /**
     * @var int
     */
    private $searchWeight;

    /**
     * @var array
     */
    private $additionalData;

    /**
     * CatalogAttributeExtension constructor.
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
     * @param bool $usedForPromoRules
     * @param int $requiredInAdminStore
     * @param int $usedInGrid
     * @param int $visibleInGrid
     * @param int $filterableInGrid
     * @param int $searchWeight
     * @param array $additionalData
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
        $requiredInAdminStore,
        $usedInGrid,
        $visibleInGrid,
        $filterableInGrid,
        $searchWeight,
        array $additionalData = [],
        array $productTypesApplyingTo = [],
        $note = null,
        $position = null
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

        $this->requiredInAdminStore = $requiredInAdminStore;
        $this->usedInGrid = $usedInGrid;
        $this->visibleInGrid = $visibleInGrid;
        $this->filterableInGrid = $filterableInGrid;
        $this->searchWeight = $searchWeight;
        $this->additionalData = $additionalData;
    }

    /**
     * @return int
     * @MagentoODM\Field('is_required_in_admin_store', version='2.*')
     */
    public function isRequiredInAdminStore()
    {
        return $this->requiredInAdminStore;
    }

    /**
     * @return int
     * @MagentoODM\Field('is_used_in_grid', version='2.*')
     */
    public function isUsedInGrid()
    {
        return $this->usedInGrid;
    }

    /**
     * @return int
     * @MagentoODM\Field('is_visible_in_grid', version='2.*')
     */
    public function isVisibleInGrid()
    {
        return $this->visibleInGrid;
    }

    /**
     * @return int
     * @MagentoODM\Field('is_filterable_in_grid', version='2.*')
     */
    public function isFilterableInGrid()
    {
        return $this->filterableInGrid;
    }

    /**
     * @return int
     * @MagentoODM\Field('search_weight', version='2.*')
     */
    public function getSearchWeight()
    {
        return $this->searchWeight;
    }

    /**
     * @return array
     * @MagentoODM\Field('additional_data', version='2.*')
     */
    public function getAdditionalData()
    {
        return $this->additionalData;
    }
}
