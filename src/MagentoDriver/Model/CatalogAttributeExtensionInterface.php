<?php

namespace Luni\Component\MagentoDriver\Model;

interface CatalogAttributeExtensionInterface
{
    /**
     * @return int
     * @MagentoODM\Field('attribute_id', version='*')
     */
    public function getId();

    /**
     * @param int $id
     */
    public function persistedToId($id);

    /**
     * @return string
     * @MagentoODM\Field('frontend_input_renderer', version='*')
     */
    public function getFrontendInputRendererClassName();

    /**
     * @return bool
     * @MagentoODM\Field('is_global', version='*')
     */
    public function isGlobal();

    /**
     * @return bool
     * @MagentoODM\Field('is_visible', version='*')
     */
    public function isVisible();

    /**
     * @return bool
     * @MagentoODM\Field('is_searchable', version='*')
     */
    public function isSearchable();

    /**
     * @return bool
     * @MagentoODM\Field('is_filterable', version='*')
     */
    public function isFilterable();

    /**
     * @return bool
     * @MagentoODM\Field('is_comparable', version='*')
     */
    public function isComparable();

    /**
     * @return bool
     * @MagentoODM\Field('is_visible_on_front', version='*')
     */
    public function isVisibleOnFront();

    /**
     * @return bool
     * @MagentoODM\Field('is_html_allowed_on_front', version='*')
     */
    public function isHtmlAllowedOnFront();

    /**
     * @return bool
     * @MagentoODM\Field('is_used_for_price_rules', version='*')
     */
    public function isUsedForPriceRules();

    /**
     * @return bool
     * @MagentoODM\Field('is_filterable_in_search', version='*')
     */
    public function isFilterableInSearch();

    /**
     * @return bool
     * @MagentoODM\Field('used_in_product_listing', version='*')
     */
    public function isUsedInProductListing();

    /**
     * @return bool
     * @MagentoODM\Field('used_for_sort_by', version='*')
     */
    public function isUsedForSortBy();

    /**
     * @return bool
     * @MagentoODM\Field('is_configurable', version='1.*')
     */
    public function isConfigurable();

    /**
     * @return bool
     * @MagentoODM\Field('is_visible_in_advanced_search', version='*')
     */
    public function isVisibleInAdvancedSearch();

    /**
     * @return bool
     * @MagentoODM\Field('is_wysiwyg_enabled', version='*')
     */
    public function isWysiwygEnabled();

    /**
     * @return bool
     * @MagentoODM\Field('is_used_for_promo_rules', version='*')
     */
    public function isUsedForPromoRules();

    /**
     * @return bool
     * @MagentoODM\Field('is_required_in_admin_store', version='2.*')
     */
    public function isRequiredInAdminStore();

    /**
     * @return bool
     * @MagentoODM\Field('is_used_in_grid', version='2.*')
     */
    public function isUsedInGrid();

    /**
     * @return bool
     * @MagentoODM\Field('is_visible_in_grid', version='2.*')
     */
    public function isVisibleInGrid();

    /**
     * @return bool
     * @MagentoODM\Field('is_filterable_in_grid', version='2.*')
     */
    public function isFilterableInGrid();

    /**
     * @return int
     * @MagentoODM\Field('position', version='*')
     */
    public function getPosition();

    /**
     * @return int
     * @MagentoODM\Field('search_weight', version='2.*')
     */
    public function getSearchWeight();

    /**
     * @return string[]
     * @MagentoODM\Field('apply_to', version='*')
     */
    public function getProductTypesApplyingTo();

    /**
     * @return array
     * @MagentoODM\Field('additional_data', version='2.*')
     */
    public function getAdditionalData();
}