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
    private $isConfigurable;

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
     * @param bool $configurable,
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
        $configurable = false,
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
        $this->id = $attributeId;
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
        $this->configurable = (bool) $configurable;
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
     * @return int
     * @MagentoODM\Field('attribute_id', version='*')
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     * @MagentoODM\Field('frontend_input_renderer', version='*')
     */
    public function getFrontendInputRendererClassName()
    {
        return $this->frontendInputRendererClassName;
    }

    /**
     * @return bool
     * @MagentoODM\Field('is_global', version='*')
     */
    public function isGlobal()
    {
        return (bool) $this->global;
    }

    /**
     * @return bool
     * @MagentoODM\Field('is_visible', version='*')
     */
    public function isVisible()
    {
        return (bool) $this->visible;
    }

    /**
     * @return bool
     * @MagentoODM\Field('is_searchable', version='*')
     */
    public function isSearchable()
    {
        return (bool) $this->searchable;
    }

    /**
     * @return bool
     * @MagentoODM\Field('is_filterable', version='*')
     */
    public function isFilterable()
    {
        return (bool) $this->filterable;
    }

    /**
     * @return bool
     * @MagentoODM\Field('is_comparable', version='*')
     */
    public function isComparable()
    {
        return (bool) $this->comparable;
    }

    /**
     * @return bool
     * @MagentoODM\Field('is_visible_on_front', version='*')
     */
    public function isVisibleOnFront()
    {
        return (bool) $this->visibleOnFront;
    }

    /**
     * @return bool
     * @MagentoODM\Field('is_html_allowed_on_front', version='*')
     */
    public function isHtmlAllowedOnFront()
    {
        return (bool) $this->htmlAllowedOnFront;
    }

    /**
     * @return bool
     * @MagentoODM\Field('is_used_for_price_rules', version='*')
     */
    public function isUsedForPriceRules()
    {
        return (bool) $this->usedForPriceRules;
    }

    /**
     * @return bool
     * @MagentoODM\Field('is_filterable_in_search', version='*')
     */
    public function isFilterableInSearch()
    {
        return (bool) $this->filterableInSearch;
    }

    /**
     * @return bool
     * @MagentoODM\Field('used_in_product_listing', version='*')
     */
    public function isUsedInProductListing()
    {
        return (bool) $this->usedInProductListing;
    }

    /**
     * @return bool
     * @MagentoODM\Field('used_for_sort_by', version='*')
     */
    public function isUsedForSortBy()
    {
        return (bool) $this->usedForSortBy;
    }

    /**
     * @return bool
     * @MagentoODM\Field('is_configurable', version='1.*')
     */
    public function isConfigurable()
    {
        return (bool) $this->configurable;
    }

    /**
     * @return bool
     * @MagentoODM\Field('is_visible_in_advanced_search', version='*')
     */
    public function isVisibleInAdvancedSearch()
    {
        return (bool) $this->visibleInAdvancedSearch;
    }

    /**
     * @return bool
     * @MagentoODM\Field('is_wysiwyg_enabled', version='*')
     */
    public function isWysiwygEnabled()
    {
        return (bool) $this->wysiwygEnabled;
    }

    /**
     * @return bool
     * @MagentoODM\Field('is_used_for_promo_rules', version='*')
     */
    public function isUsedForPromoRules()
    {
        return (bool) $this->usedForPromoRules;
    }

    /**
     * @return bool
     * @MagentoODM\Field('is_required_in_admin_store', version='2.*')
     */
    public function isRequiredInAdminStore()
    {
        return (bool) $this->requiredInAdminStore;
    }

    /**
     * @return bool
     * @MagentoODM\Field('is_used_in_grid', version='2.*')
     */
    public function isUsedInGrid()
    {
        return (bool) $this->usedInGrid;
    }

    /**
     * @return bool
     * @MagentoODM\Field('is_visible_in_grid', version='2.*')
     */
    public function isVisibleInGrid()
    {
        return (bool) $this->visibleInGrid;
    }

    /**
     * @return bool
     * @MagentoODM\Field('is_filterable_in_grid', version='2.*')
     */
    public function isFilterableInGrid()
    {
        return (bool) $this->filterableInGrid;
    }

    /**
     * @return int
     * @MagentoODM\Field('position', version='*')
     */
    public function getPosition()
    {
        return $this->position;
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
     * @return string[]
     * @MagentoODM\Field('apply_to', version='*')
     */
    public function getProductTypesApplyingTo()
    {
        return $this->productTypesApplyingTo;
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