<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model;

class CatalogAttributeExtension implements CatalogAttributeExtensionInterface
{
    /**
     * @var int
     */
    private $identifier;

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
     * @var int
     */
    private $configurable;

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
     * @var string
     */
    private $note;
    
    /**
     * @param int $attributeId
     * @param bool $frontendInputRendererClassName
     * @param array $variableFields An associative array containing column-value pairs.
     */
    public function __construct(
        $attributeId, 
        $frontendInputRendererClassName, 
        $variableFields
    )
    {
        $this->identifier = $attributeId;
        $this->frontendInputRendererClassName = $frontendInputRendererClassName;
        $this->global = (int) @$variableFields['is_global']?: 1;
        $this->visible = (bool) @$variableFields['is_visible']?: true;
        $this->searchable = (bool) @$variableFields['is_searchable']?: false;
        $this->filterable = (bool) @$variableFields['is_filterable']?: false;
        $this->comparable = (bool) @$variableFields['is_comparable']?: false;
        $this->visibleOnFront = (bool) @$variableFields['is_visible_on_front']?: false;
        $this->htmlAllowedOnFront = (bool) @$variableFields['is_html_allowed_on_front']?: false;
        $this->usedForPriceRules = (bool) @$variableFields['is_used_for_price_rules']?: false;
        $this->filterableInSearch = (bool) @$variableFields['is_filterable_in_search']?: false;
        $this->usedInProductListing = (bool) @$variableFields['used_in_product_listing']?: false;
        $this->usedForSortBy = (bool) @$variableFields['used_for_sort_by']?: false;
        $this->configurable = (isset($variableFields['is_configurable'])) ? (int) $variableFields['is_configurable'] : null; // M1
        $this->productTypesApplyingTo = (array) @$variableFields['apply_to']?: null;
        $this->visibleInAdvancedSearch = (bool) @$variableFields['is_visible_in_advanced_search']?: false;
        $this->position = (int) @$variableFields['position']?: 0;
        $this->wysiwygEnabled = (bool) @$variableFields['is_wysiwyg_enabled']?: false;
        $this->usedForPromoRules = (bool) @$variableFields['is_used_for_promo_rules']?: false;
        // M2 fields
        $this->requiredInAdminStore = (bool) @$variableFields['is_required_in_admin_store']?: null;
        $this->usedInGrid = (bool) @$variableFields['is_used_in_grid']?: null;
        $this->visibleInGrid = (bool) @$variableFields['is_visible_in_grid']?: null;
        $this->filterableInGrid = (bool) @$variableFields['is_filterable_in_grid']?: null;
        $this->searchWeight =(isset($variableFields['search_weight'])) ? (int) $variableFields['search_weight'] : null;
        $this->additionalData = (array) @$variableFields['additional_data']?: null;
        $this->note = (string) @$variableFields['note']?: null;
        
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
     * @return int
     * @MagentoODM\Field('is_global', version='*')
     */
    public function isGlobal()
    {
        return (int) $this->global;
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
     * @return int
     * @MagentoODM\Field('is_configurable', version='1.*')
     */
    public function isConfigurable()
    {
        return $this->configurable;
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
