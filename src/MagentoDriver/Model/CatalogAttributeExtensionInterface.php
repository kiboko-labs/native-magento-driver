<?php

namespace Luni\Component\MagentoDriver\Model;

interface CatalogAttributeExtensionInterface
{
    /**
     * @return int
     * @field attribute_id
     */
    public function getId();

    /**
     * @return string
     * @field frontend_input_renderer
     */
    public function getFrontendInputRendererClassName();

    /**
     * @return bool
     * @field is_global
     */
    public function isGlobal();

    /**
     * @return bool
     * @field is_visible
     */
    public function isVisible();

    /**
     * @return bool
     * @field is_searchable
     */
    public function isSearchable();

    /**
     * @return bool
     * @field is_filterable
     */
    public function isFilterable();

    /**
     * @return bool
     * @field is_comparable
     */
    public function isComparable();

    /**
     * @return bool
     * @field is_visible_on_front
     */
    public function isVisibleOnFront();

    /**
     * @return bool
     * @field is_html_allowed_on_front
     */
    public function isHtmlAllowedOnFront();

    /**
     * @return bool
     * @field is_used_for_price_rules
     */
    public function isUsedForPriceRules();

    /**
     * @return bool
     * @field is_filterable_in_search
     */
    public function isFilterableInSearch();

    /**
     * @return bool
     * @field used_in_product_listing
     */
    public function isUsedInProductListing();

    /**
     * @return bool
     * @field used_for_sort_by
     */
    public function isUsedForSortBy();

    /**
     * @return bool
     * @field is_configurable
     */
    public function isConfigurable();

    /**
     * @return bool
     * @field is_visible_in_advanced_search
     */
    public function isVisibleInAdvancedSearch();

    /**
     * @return bool
     * @field is_wysiwyg_enabled
     */
    public function isWysiwygEnabled();

    /**
     * @return bool
     * @field is_used_for_promo_rules
     */
    public function isUsedForPromoRules();

    /**
     * @return bool
     * @field is_required_in_admin_store
     */
    public function isRequiredInAdminStore();

    /**
     * @return bool
     * @field is_used_in_grid
     */
    public function isUsedInGrid();

    /**
     * @return bool
     * @field is_visible_in_grid
     */
    public function isVisibleInGrid();

    /**
     * @return bool
     * @field is_filterable_in_grid
     */
    public function isFilterableInGrid();

    /**
     * @return int
     * @field position
     */
    public function getPosition();

    /**
     * @return int
     * @field search_weight
     */
    public function getSearchWeight();

    /**
     * @return string[]
     * @field apply_to
     */
    public function getProductTypesApplyingTo();

    /**
     * @return array
     * @field additional_data
     */
    public function getAdditionalData();
}
