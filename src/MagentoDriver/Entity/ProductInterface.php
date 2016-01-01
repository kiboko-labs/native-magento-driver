<?php

namespace Luni\Component\MagentoDriver\Entity;

use Doctrine\Common\Collections\Collection;
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

    /**
     * @return string
     */
    public function getIdentifier();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return FamilyInterface
     */
    public function getFamily();

    /**
     * @return bool
     */
    public function isConfigurable();

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