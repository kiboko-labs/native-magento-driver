<?php

namespace Kiboko\Component\MagentoDriver\Entity\Product;

use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoDriver\Entity\EntityInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\Immutable\ImmutableAttributeValueInterface;
use Kiboko\Component\MagentoDriver\Model\MediaGalleryAttributeInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeValueInterface;
use Kiboko\Component\MagentoDriver\Model\MediaGalleryAttributeValueInterface;
use Kiboko\Component\MagentoDriver\Model\FamilyInterface;
use Kiboko\Component\MagentoDriver\Model\Mutable\MutableAttributeValueInterface;

interface ProductInterface extends EntityInterface
{
    const TYPE_SIMPLE = 'simple';
    const TYPE_VIRTUAL = 'virtual';
    const TYPE_CONFIGURABLE = 'configurable';
    const TYPE_GROUPED = 'grouped';
    const TYPE_BUNDLE = 'bundle';
    const TYPE_DOWNLOADABLE = 'downloadable';
    const TYPE_GIFT_CARD = 'gift_card';

    const VISIBILITY_NOT_VISIBLE = 1;
    const VISIBILITY_IN_CATALOG = 2;
    const VISIBILITY_IN_SEARCH = 3;
    const VISIBILITY_BOTH = 4;

    const ENTITY_TYPE_ID = 4;
    const ENTITY_CODE = 'catalog_product';

    /**
     * @param int $identifier
     *
     * @return ProductInterface
     */
    public function persistedToId($identifier);

    /**
     * @return string
     */
    public function getIdentifier();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return int
     */
    public function getFamilyId();

    /**
     * @param FamilyInterface $family
     */
    public function changeFamily(FamilyInterface $family);

    /**
     * @return FamilyInterface
     */
    public function getFamily();

    /**
     * @return bool
     */
    public function isConfigurable();

    /**
     * @return bool
     */
    public function isNotVisible();

    /**
     * @return bool
     */
    public function isVisibleInCatalog();

    /**
     * @return bool
     */
    public function isVisibleInSearch();

    /**
     * @return bool
     */
    public function isVisibleInCatalogAndSearch();

    /**
     * @return bool
     */
    public function isVisibleSomewhere();

    public function setNotVisible();

    public function setVisibleInCatalog();

    public function setVisibleInSearch();

    public function setVisibleInCatalogAndSearch();

    /**
     * @return bool
     */
    public function hasOptions();

    public function getRequiredOptions();

    /**
     * @return \DateTimeInterface
     */
    public function getCreationDate();

    /**
     * @return \DateTimeInterface
     */
    public function getModificationDate();

    /**
     * @param AttributeInterface $attribute
     * @param int                $storeId
     *
     * @return bool
     */
    public function hasValueFor(AttributeInterface $attribute, $storeId);

    /**
     * @param AttributeInterface $attribute
     * @param int                $storeId
     *
     * @return AttributeValueInterface
     */
    public function getValueFor(AttributeInterface $attribute, $storeId);

    /**
     * @param string $attributeCode
     * @param int    $storeId
     *
     * @return ImmutableAttributeValueInterface
     */
    public function getValueByAttributeCode($attributeCode, $storeId = null);

    /**
     * @param AttributeInterface $attribute
     * @param int                $storeId
     *
     * @return ImmutableAttributeValueInterface
     */
    public function getImmutableValueFor(AttributeInterface $attribute, $storeId);

    /**
     * @param string $attributeCode
     * @param int    $storeId
     *
     * @return ImmutableAttributeValueInterface
     */
    public function getImmutableValueByAttributeCode($attributeCode, $storeId);

    /**
     * @param AttributeInterface $attribute
     * @param int                $storeId
     *
     * @return MutableAttributeValueInterface
     */
    public function getMutableValueFor(AttributeInterface $attribute, $storeId);

    /**
     * @param string $attributeCode
     * @param int    $storeId
     *
     * @return MutableAttributeValueInterface
     */
    public function getMutableValueByAttributeCode($attributeCode, $storeId);

    /**
     * @param AttributeInterface $attribute
     *
     * @return Collection|AttributeValueInterface[]
     */
    public function getAllValuesFor(AttributeInterface $attribute);

    /**
     * @param string $attributeCode
     *
     * @return Collection|AttributeValueInterface[]
     */
    public function getAllValuesByAttributeCode($attributeCode);

    /**
     * @param AttributeValueInterface $value
     */
    public function setValue(AttributeValueInterface $value);

    /**
     * @param MediaGalleryAttributeInterface $attribute
     * @param int                            $storeId
     *
     * @return MediaGalleryAttributeValueInterface
     */
    public function getMediaGalleryFor(MediaGalleryAttributeInterface $attribute, $storeId);
}
