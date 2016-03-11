<?php

namespace Luni\Component\MagentoDriver\Model;

class CatalogAttributeExtension
    implements CatalogAttributeExtensionInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $frontendInputRendererClassName;

    /**
     * @var int
     */
    private $global;

    /**
     * @var bool
     */
    private $visible;

    /**
     * @var bool
     */
    private $searchable;

    /**
     * @var bool
     */
    private $filterable;

    /**
     * @var bool
     */
    private $comparable;

    /**
     * @var bool
     */
    private $visibleOnFront;

    /**
     * @var bool
     */
    private $htmlAllowedOnFront;

    /**
     * @var bool
     */
    private $usedForPriceRules;

    /**
     * @var bool
     */
    private $filterableInSearch;

    /**
     * @var bool
     */
    private $usedInProductListing;

    /**
     * @var bool
     */
    private $usedForSortBy;

    /**
     * @var bool
     */
    private $visibleInAdvancedSearch;

    /**
     * @var bool
     */
    private $wysiwygEnabled;

    /**
     * @var bool
     */
    private $usedForPromoRules;

    /**
     * @var bool
     */
    private $requiredInAdminStore;

    /**
     * @var bool
     */
    private $usedInGrid;

    /**
     * @var bool
     */
    private $visibleInGrid;

    /**
     * @var bool
     */
    private $filterableInGrid;

    /**
     * @var int
     */
    private $position;

    /**
     * @var int
     */
    private $searchWeight;

    /**
     * @var array
     */
    private $productTypesApplyingTo;

    /**
     * @var array
     */
    private $additionalData;

    /**
     * @param bool $frontendInputRendererClassName,
     * @param int $global,
     * @param bool $visible,
     * @param bool $searchable,
     * @param bool $filterable,
     * @param bool $comparable,
     * @param bool $visibleOnFront,
     * @param bool $htmlAllowedOnFront,
     * @param bool $usedForPriceRules,
     * @param bool $filterableInSearch,
     * @param bool $usedInProductListing,
     * @param bool $usedForSortBy,
     * @param bool $visibleInAdvancedSearch,
     * @param bool $wysiwygEnabled,
     * @param bool $usedForPromoRules,
     * @param bool $requiredInAdminStore,
     * @param bool $usedInGrid,
     * @param bool $visibleInGrid,
     * @param bool $filterableInGrid,
     * @param bool $position,
     * @param bool $searchWeight,
     * @param array $productTypesApplyingTo,
     * @param array $additionalData,
     * @param string $note
     */
    public function __construct(
        $frontendInputRendererClassName,
        $global = 1,
        $visible = false,
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
        $requiredInAdminStore = false,
        $usedInGrid = false,
        $visibleInGrid = false,
        $filterableInGrid = false,
        $position = false,
        $searchWeight = false,
        array $productTypesApplyingTo = [],
        array $additionalData = [],
        $note = null
    ) {
        $this->frontendInputRendererClassName = $frontendInputRendererClassName;
        $this->global = $global;
        $this->visible = (bool) $visible;
        $this->searchable = (bool) $searchable;
        $this->filterable = (bool) $filterable;
        $this->comparable = (bool) $comparable;
        $this->visibleOnFront = (bool) $visibleOnFront;
        $this->htmlAllowedOnFront = (bool) $htmlAllowedOnFront;
        $this->usedForPriceRules = (bool) $usedForPriceRules;
        $this->filterableInSearch = (bool) $filterableInSearch;
        $this->usedInProductListing = (bool) $usedInProductListing;
        $this->usedForSortBy = (bool) $usedForSortBy;
        $this->visibleInAdvancedSearch = (bool) $visibleInAdvancedSearch;
        $this->wysiwygEnabled = (bool) $wysiwygEnabled;
        $this->usedForPromoRules = (bool) $usedForPromoRules;
        $this->requiredInAdminStore = (bool) $requiredInAdminStore;
        $this->usedInGrid = (bool) $usedInGrid;
        $this->visibleInGrid = (bool) $visibleInGrid;
        $this->filterableInGrid = (bool) $filterableInGrid;
        $this->position = $position;
        $this->searchWeight = $searchWeight;
        $this->productTypesApplyingTo = $productTypesApplyingTo;
        $this->additionalData = $additionalData;
        $this->note = $note;
    }

    /**
     * @param int $attributeId
     * @param bool $frontendInputRendererClassName,
     * @param int $global,
     * @param bool $visible,
     * @param bool $searchable,
     * @param bool $filterable,
     * @param bool $comparable,
     * @param bool $visibleOnFront,
     * @param bool $htmlAllowedOnFront,
     * @param bool $usedForPriceRules,
     * @param bool $filterableInSearch,
     * @param bool $usedInProductListing,
     * @param bool $usedForSortBy,
     * @param bool $visibleInAdvancedSearch,
     * @param bool $wysiwygEnabled,
     * @param bool $usedForPromoRules,
     * @param bool $requiredInAdminStore,
     * @param bool $usedInGrid,
     * @param bool $visibleInGrid,
     * @param bool $filterableInGrid,
     * @param bool $position,
     * @param bool $searchWeight,
     * @param array $productTypesApplyingTo,
     * @param array $additionalData,
     * @param string $note
     * @return AttributeInterface
     */
    public static function buildNewWith(
        $attributeId,
        $frontendInputRendererClassName,
        $global = 1,
        $visible = false,
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
        $requiredInAdminStore = false,
        $usedInGrid = false,
        $visibleInGrid = false,
        $filterableInGrid = false,
        $position = false,
        $searchWeight = false,
        array $productTypesApplyingTo = [],
        array $additionalData = [],
        $note = null
    ) {
        $object = new self(
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
            $requiredInAdminStore,
            $usedInGrid,
            $visibleInGrid,
            $filterableInGrid,
            $position,
            $searchWeight,
            $productTypesApplyingTo,
            $additionalData,
            $note
        );

        $object->id = $attributeId;

        return $object;
    }

    /**
     * @return bool
     */
    public function getFrontendInputRendererClassName()
    {
        return $this->frontendInputRendererClassName;
    }

    /**
     * @return bool
     */
    public function isGlobal()
    {
        return (bool) $this->global;
    }

    /**
     * @return bool
     */
    public function isVisible()
    {
        return (bool) $this->visible;
    }

    /**
     * @return bool
     */
    public function isSearchable()
    {
        return (bool) $this->searchable;
    }

    /**
     * @return bool
     */
    public function isFilterable()
    {
        return (bool) $this->filterable;
    }

    /**
     * @return bool
     */
    public function isComparable()
    {
        return (bool) $this->comparable;
    }

    /**
     * @return bool
     */
    public function isVisibleOnFront()
    {
        return (bool) $this->visibleOnFront;
    }

    /**
     * @return bool
     */
    public function isHtmlAllowedOnFront()
    {
        return (bool) $this->htmlAllowedOnFront;
    }

    /**
     * @return bool
     */
    public function isUsedForPriceRules()
    {
        return (bool) $this->usedForPriceRules;
    }

    /**
     * @return bool
     */
    public function isFilterableInSearch()
    {
        return (bool) $this->filterableInSearch;
    }

    /**
     * @return bool
     */
    public function isUsedInProductListing()
    {
        return (bool) $this->usedInProductListing;
    }

    /**
     * @return bool
     */
    public function isUsedForSortBy()
    {
        return (bool) $this->usedForSortBy;
    }

    /**
     * @return bool
     */
    public function isVisibleInAdvancedSearch()
    {
        return (bool) $this->visibleInAdvancedSearch;
    }

    /**
     * @return bool
     */
    public function isWysiwygEnabled()
    {
        return (bool) $this->wysiwygEnabled;
    }

    /**
     * @return bool
     */
    public function isUsedForPromoRules()
    {
        return (bool) $this->usedForPromoRules;
    }

    /**
     * @return bool
     */
    public function isRequiredInAdminStore()
    {
        return (bool) $this->requiredInAdminStore;
    }

    /**
     * @return bool
     */
    public function isUsedInGrid()
    {
        return (bool) $this->usedInGrid;
    }

    /**
     * @return bool
     */
    public function isVisibleInGrid()
    {
        return (bool) $this->visibleInGrid;
    }

    /**
     * @return bool
     */
    public function isFilterableInGrid()
    {
        return (bool) $this->filterableInGrid;
    }

    /**
     * @return bool
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function getSearchWeight()
    {
        return $this->searchWeight;
    }

    /**
     * @return array
     */
    public function getProductTypesApplyingTo()
    {
        return $this->productTypesApplyingTo;
    }

    /**
     * @return array
     */
    public function getAdditionalData()
    {
        return $this->additionalData;
    }
}