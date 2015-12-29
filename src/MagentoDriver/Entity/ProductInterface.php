<?php

namespace Luni\Component\MagentoDriver\Entity;

use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\Attribute\MediaGalleryAttributeInterface;
use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\MediaGalleryAttributeValueInterface;
use Luni\Component\MagentoDriver\Family\FamilyInterface;

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