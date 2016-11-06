<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model;

abstract class AbstractCatalogAttributeExtension implements CatalogAttributeExtensionInterface
{
    use IdentifiableTrait;

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
     * @var string
     */
    private $note;

    /**
     * @var int
     */
    private $position;

    /**
     * @var array
     */
    private $productTypesApplyingTo;

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
        array $productTypesApplyingTo = [],
        $note = null,
        $position = null
    ) {
        $this->identifier = $attributeId;
        $this->frontendInputRendererClassName = $frontendInputRendererClassName;
        $this->global = $global;
        $this->visible = $visible;
        $this->searchable = $searchable;
        $this->filterable = $filterable;
        $this->comparable = $comparable;
        $this->visibleOnFront = $visibleOnFront;
        $this->htmlAllowedOnFront = $htmlAllowedOnFront;
        $this->usedForPriceRules = $usedForPriceRules;
        $this->filterableInSearch = $filterableInSearch;
        $this->usedInProductListing = $usedInProductListing;
        $this->usedForSortBy = $usedForSortBy;
        $this->visibleInAdvancedSearch = $visibleInAdvancedSearch;
        $this->wysiwygEnabled = $wysiwygEnabled;
        $this->usedForPromoRules = $usedForPromoRules;
        $this->note = $note;
        $this->position = $position;
        $this->productTypesApplyingTo = $productTypesApplyingTo;
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
     * @MagentoODM\Field('position', version='*')
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return string[]
     * @MagentoODM\Field('apply_to', version='*')
     */
    public function getProductTypesApplyingTo()
    {
        return $this->productTypesApplyingTo;
    }
}
