<?php

namespace Luni\Component\MagentoDriver\Model;

use Luni\Component\MagentoDriver\Exception\RuntimeErrorException;

class CatalogAttribute
    implements AttributeInterface, CatalogAttributeExtensionInterface
{
    /**
     * @var AttributeInterface
     */
    private $attribute;

    /**
     * @var CatalogAttributeExtensionInterface
     */
    private $extensios;

    /**
     * @param AttributeInterface $attribute
     * @param CatalogAttributeExtensionInterface $extensios
     */
    public function __construct(
        AttributeInterface $attribute,
        CatalogAttributeExtensionInterface $extensios
    ) {
        if ($attribute->getId() !== $extensios->getId()) {
            throw new RuntimeErrorException('Extension\'s attribute ID should match the attribute\'s.');
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->attribute->getId();
    }

    /**
     * @return int
     */
    public function getEntityTypeId()
    {
        return $this->attribute->getEntityTypeId();
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->attribute->getCode();
    }

    /**
     * @return string
     */
    public function getModelClass()
    {
        return $this->attribute->getModelClass();
    }

    /**
     * @return string
     */
    public function getBackendModelClass()
    {
        return $this->attribute->getBackendModelClass();
    }

    /**
     * @return string
     */
    public function getBackendTable()
    {
        return $this->attribute->getBackendTable();
    }

    /**
     * @return string
     */
    public function getFrontendModelClass()
    {
        return $this->attribute->getFrontendModelClass();
    }

    /**
     * @return string
     */
    public function getFrontendInput()
    {
        return $this->attribute->getFrontendInput();
    }

    /**
     * @return string
     */
    public function getFrontendLabel()
    {
        return $this->attribute->getFrontendLabel();
    }

    /**
     * @return string
     */
    public function getFrontendViewClass()
    {
        return $this->attribute->getFrontendViewClass();
    }

    /**
     * @return string
     */
    public function getSourceModelClass()
    {
        return $this->attribute->getSourceModelClass();
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return $this->attribute->isRequired();
    }

    /**
     * @return bool
     */
    public function isUserDefined()
    {
        return $this->attribute->isUserDefined();
    }

    /**
     * @return bool
     */
    public function isSystem()
    {
        return $this->attribute->isSystem();
    }

    /**
     * @return bool
     */
    public function isUnique()
    {
        return $this->attribute->isUnique();
    }

    /**
     * @return string
     */
    public function getDefaultValue()
    {
        return $this->attribute->getDefaultValue();
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->attribute->getNote();
    }

    /**
     * @return bool
     */
    public function getFrontendInputRendererClassName()
    {
        return $this->extensios->getFrontendInputRendererClassName();
    }

    /**
     * @return bool
     */
    public function isGlobal()
    {
        return $this->extensios->isGlobal();
    }

    /**
     * @return bool
     */
    public function isVisible()
    {
        return $this->extensios->isVisible();
    }

    /**
     * @return bool
     */
    public function isSearchable()
    {
        return $this->extensios->isSearchable();
    }

    /**
     * @return bool
     */
    public function isFilterable()
    {
        return $this->extensios->isFilterable();
    }

    /**
     * @return bool
     */
    public function isComparable()
    {
        return $this->extensios->isComparable();
    }

    /**
     * @return bool
     */
    public function isVisibleOnFront()
    {
        return $this->extensios->isVisibleOnFront();
    }

    /**
     * @return bool
     */
    public function isHtmlAllowedOnFront()
    {
        return $this->extensios->isHtmlAllowedOnFront();
    }

    /**
     * @return bool
     */
    public function isUsedForPriceRules()
    {
        return $this->extensios->isUsedForPriceRules();
    }

    /**
     * @return bool
     */
    public function isFilterableInSearch()
    {
        return $this->extensios->isFilterableInSearch();
    }

    /**
     * @return bool
     */
    public function isUsedInProductListing()
    {
        return $this->extensios->isUsedInProductListing();
    }

    /**
     * @return bool
     */
    public function isUsedForSortBy()
    {
        return $this->extensios->isUsedForSortBy();
    }

    /**
     * @return bool
     */
    public function isVisibleInAdvancedSearch()
    {
        return $this->extensios->isVisibleInAdvancedSearch();
    }

    /**
     * @return bool
     */
    public function isWysiwygEnabled()
    {
        return $this->extensios->isWysiwygEnabled();
    }

    /**
     * @return bool
     */
    public function isUsedForPromoRules()
    {
        return $this->extensios->isUsedForPromoRules();
    }

    /**
     * @return bool
     */
    public function isRequiredInAdminStore()
    {
        return $this->extensios->isRequiredInAdminStore();
    }

    /**
     * @return bool
     */
    public function isUsedInGrid()
    {
        return $this->extensios->isUsedInGrid();
    }

    /**
     * @return bool
     */
    public function isVisibleInGrid()
    {
        return $this->extensios->isVisibleInGrid();
    }

    /**
     * @return bool
     */
    public function isFilterableInGrid()
    {
        return $this->extensios->isFilterableInGrid();
    }

    /**
     * @return bool
     */
    public function getPosition()
    {
        return $this->extensios->getPosition();
    }

    /**
     * @return bool
     */
    public function getSearchWeight()
    {
        return $this->extensios->getSearchWeight();
    }

    /**
     * @return array
     */
    public function getProductTypesApplyingTo()
    {
        return $this->extensios->getProductTypesApplyingTo();
    }

    /**
     * @return array
     */
    public function getAdditionalData()
    {
        return $this->extensios->getAdditionalData();
    }
}