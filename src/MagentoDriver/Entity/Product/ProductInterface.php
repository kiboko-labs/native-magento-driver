<?php

namespace Luni\Component\MagentoDriver\Entity\Product;

use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Entity\EntityInterface;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\Immutable\ImmutableAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\MediaGalleryAttributeInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Model\MediaGalleryAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\FamilyInterface;
use Luni\Component\MagentoDriver\Model\Mutable\MutableAttributeValueInterface;

interface ProductInterface
    extends EntityInterface
{
    const TYPE_SIMPLE       = 'simple';
    const TYPE_VIRTUAL      = 'virtual';
    const TYPE_CONFIGURABLE = 'configurable';
    const TYPE_GROUPED      = 'grouped';
    const TYPE_BUNDLE       = 'bundle';
    const TYPE_DOWNLOADABLE = 'downloadable';
    const TYPE_GIFT_CARD    = 'gift_card';

    const VISIBILITY_NOT_VISIBLE    = 1;
    const VISIBILITY_IN_CATALOG     = 2;
    const VISIBILITY_IN_SEARCH      = 3;
    const VISIBILITY_BOTH           = 4;

    /**
     * @param int $id
     * @return ProductInterface
     */
    public function persistedToId($id);

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
     * @return AttributeInterface[]|Collection
     */
    public function getAxisAttributes();

    /**
     * @return bool
     */
    public function hasOptions();

    /**
     * @return null
     */
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
     * @param int $storeId
     * @return bool
     */
    public function hasValueFor(AttributeInterface $attribute, $storeId);

    /**
     * @param AttributeInterface $attribute
     * @param int $storeId
     * @return AttributeValueInterface
     */
    public function getValueFor(AttributeInterface $attribute, $storeId);

    /**
     * @param AttributeInterface $attribute
     * @param int $storeId
     * @return ImmutableAttributeValueInterface
     */
    public function getImmutableValueFor(AttributeInterface $attribute, $storeId);

    /**
     * @param AttributeInterface $attribute
     * @param int $storeId
     * @return MutableAttributeValueInterface
     */
    public function getMutableValueFor(AttributeInterface $attribute, $storeId);

    /**
     * @param AttributeInterface $attribute
     * @return Collection|AttributeValueInterface[]
     */
    public function getAllValuesFor(AttributeInterface $attribute);

    /**
     * @param AttributeValueInterface $value
     */
    public function setValue(AttributeValueInterface $value);

    /**
     * @param MediaGalleryAttributeInterface $attribute
     * @param int $storeId
     * @return MediaGalleryAttributeValueInterface
     */
    public function getMediaGalleryFor(MediaGalleryAttributeInterface $attribute, $storeId);
}
