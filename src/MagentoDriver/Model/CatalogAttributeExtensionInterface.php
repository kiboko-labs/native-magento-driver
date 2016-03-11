<?php

namespace Luni\Component\MagentoDriver\Model;

interface CatalogAttributeExtensionInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getFrontendInputRendererClassName();

    /**
     * @return bool
     */
    public function isGlobal();

    /**
     * @return bool
     */
    public function isVisible();

    /**
     * @return bool
     */
    public function isSearchable();

    /**
     * @return bool
     */
    public function isFilterable();

    /**
     * @return bool
     */
    public function isComparable();

    /**
     * @return bool
     */
    public function isVisibleOnFront();

    /**
     * @return bool
     */
    public function isHtmlAllowedOnFront();

    /**
     * @return bool
     */
    public function isUsedForPriceRules();

    /**
     * @return bool
     */
    public function isFilterableInSearch();

    /**
     * @return bool
     */
    public function isUsedInProductListing();

    /**
     * @return bool
     */
    public function isUsedForSortBy();

    /**
     * @return bool
     */
    public function isVisibleInAdvancedSearch();

    /**
     * @return bool
     */
    public function isWysiwygEnabled();

    /**
     * @return bool
     */
    public function isUsedForPromoRules();

    /**
     * @return bool
     */
    public function isRequiredInAdminStore();

    /**
     * @return bool
     */
    public function isUsedInGrid();

    /**
     * @return bool
     */
    public function isVisibleInGrid();

    /**
     * @return bool
     */
    public function isFilterableInGrid();

    /**
     * @return int
     */
    public function getPosition();

    /**
     * @return int
     */
    public function getSearchWeight();

    /**
     * @return string[]
     */
    public function getProductTypesApplyingTo();

    /**
     * @return array
     */
    public function getAdditionalData();
}