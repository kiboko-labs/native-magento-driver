<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

interface CatalogAttributeExtensionInterface extends IdentifiableInterface
{
    const SCOPE_GLOBAL = 1;
    const SCOPE_WEBSITE = 2;
    const SCOPE_STORE = 0;

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
     * @return int
     */
    public function getPosition();

    /**
     * @return string[]
     */
    public function getProductTypesApplyingTo();
}
