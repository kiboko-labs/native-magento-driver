<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model\V2_0ce;

use Kiboko\Component\MagentoORM\Exception\RuntimeErrorException;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\MappableTrait;

class CatalogAttribute implements CatalogAttributeInterface
{
    use MappableTrait;

    /**
     * @var AttributeInterface
     */
    private $attribute;

    /**
     * @var CatalogAttributeExtensionInterface
     */
    private $extension;

    /**
     * @param AttributeInterface                 $attribute
     * @param CatalogAttributeExtensionInterface $extension
     */
    public function __construct(
        AttributeInterface $attribute,
        CatalogAttributeExtensionInterface $extension
    ) {
        if ($attribute->getId() !== $extension->getId()) {
            throw new RuntimeErrorException('Extension\'s attribute ID should match the attribute\'s.');
        }

        $this->attribute = $attribute;
        $this->extension = $extension;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->attribute->getId();
    }

    /**
     * @param int $identifier
     */
    public function persistedToId($identifier)
    {
        $this->attribute->persistedToId($identifier);
        $this->extension->persistedToId($identifier);
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
    public function getBackendType()
    {
        return $this->attribute->getBackendType();
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
     * @return string
     */
    public function getFrontendInputRendererClassName()
    {
        return $this->extension->getFrontendInputRendererClassName();
    }

    /**
     * @return bool
     */
    public function isGlobal()
    {
        return $this->extension->isGlobal();
    }

    /**
     * @return bool
     */
    public function isVisible()
    {
        return $this->extension->isVisible();
    }

    /**
     * @return bool
     */
    public function isSearchable()
    {
        return $this->extension->isSearchable();
    }

    /**
     * @return bool
     */
    public function isFilterable()
    {
        return $this->extension->isFilterable();
    }

    /**
     * @return bool
     */
    public function isComparable()
    {
        return $this->extension->isComparable();
    }

    /**
     * @return bool
     */
    public function isVisibleOnFront()
    {
        return $this->extension->isVisibleOnFront();
    }

    /**
     * @return bool
     */
    public function isHtmlAllowedOnFront()
    {
        return $this->extension->isHtmlAllowedOnFront();
    }

    /**
     * @return bool
     */
    public function isUsedForPriceRules()
    {
        return $this->extension->isUsedForPriceRules();
    }

    /**
     * @return bool
     */
    public function isFilterableInSearch()
    {
        return $this->extension->isFilterableInSearch();
    }

    /**
     * @return bool
     */
    public function isUsedInProductListing()
    {
        return $this->extension->isUsedInProductListing();
    }

    /**
     * @return bool
     */
    public function isUsedForSortBy()
    {
        return $this->extension->isUsedForSortBy();
    }

    /**
     * @return bool
     */
    public function isVisibleInAdvancedSearch()
    {
        return $this->extension->isVisibleInAdvancedSearch();
    }

    /**
     * @return bool
     */
    public function isWysiwygEnabled()
    {
        return $this->extension->isWysiwygEnabled();
    }

    /**
     * @return bool
     */
    public function isUsedForPromoRules()
    {
        return $this->extension->isUsedForPromoRules();
    }

    /**
     * @return bool
     */
    public function isRequiredInAdminStore()
    {
        return $this->extension->isRequiredInAdminStore();
    }

    /**
     * @return bool
     */
    public function isUsedInGrid()
    {
        return $this->extension->isUsedInGrid();
    }

    /**
     * @return bool
     */
    public function isVisibleInGrid()
    {
        return $this->extension->isVisibleInGrid();
    }

    /**
     * @return bool
     */
    public function isFilterableInGrid()
    {
        return $this->extension->isFilterableInGrid();
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->extension->getPosition();
    }

    /**
     * @return int
     */
    public function getSearchWeight()
    {
        return $this->extension->getSearchWeight();
    }

    /**
     * @return array
     */
    public function getProductTypesApplyingTo()
    {
        return $this->extension->getProductTypesApplyingTo();
    }

    /**
     * @return array
     */
    public function getAdditionalData()
    {
        return $this->extension->getAdditionalData();
    }
}
