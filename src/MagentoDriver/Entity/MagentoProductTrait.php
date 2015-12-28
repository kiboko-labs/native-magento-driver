<?php

namespace Luni\Component\MagentoDriver\Entity;

use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\Attribute\MediaGalleryAttributeInterface;
use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\Immutable\ImmutableAttributeValueInterface;
use Luni\Component\MagentoDriver\Exception\ImmutableValueException;
use Luni\Component\MagentoDriver\Family\FamilyInterface;

trait MagentoProductTrait
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var Collection|AttributeInterface[]
     */
    private $axisAttributes;

    /**
     * @var Collection|AttributeInterface[]
     */
    private $attributes;

    /**
     * @var Collection|AttributeValueInterface[]
     */
    private $values;

    /**
     * @var FamilyInterface
     */
    private $family;

    /**
     * @var bool
     */
    private $productType;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Collection|AttributeInterface[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return Collection|AttributeValueInterface[]
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @return FamilyInterface
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * @return bool
     */
    public function isConfigurable()
    {
        return $this->productType === ProductInterface::TYPE_CONFIGURABLE;
    }

    /**
     * @return Collection|AttributeInterface[]
     */
    public function getAxisAttributes()
    {
        return $this->axisAttributes;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param AttributeInterface $attribute
     * @param int $storeId
     * @return bool
     */
    public function hasValueFor(AttributeInterface $attribute, $storeId = null)
    {
        /** @var AttributeValueInterface $value */
        foreach ($this->values as $value) {
            if ($value->getAttributeCode() !== $attribute->getCode()) {
                continue;
            }

            if ($value->getStoreId() === $storeId) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param AttributeInterface $attribute
     * @param int $storeId
     * @return ImmutableAttributeValueInterface
     */
    public function getValueFor(AttributeInterface $attribute, $storeId = null)
    {
        /** @var AttributeValueInterface $value */
        foreach ($this->values as $value) {
            if ($value->getAttributeCode() !== $attribute->getCode()) {
                continue;
            }

            if ($value->getStoreId() === $storeId) {
                return $value;
            }
        }

        return false;
    }

    /**
     * @param AttributeValueInterface $newValue
     */
    public function setValue(AttributeValueInterface $newValue)
    {
        /** @var AttributeValueInterface $value */
        foreach ($this->values as $value) {
            if ($value->getAttributeCode() === $newValue->getAttributeCode() &&
                $value->getStoreId() === $newValue->getStoreId()) {
                throw new ImmutableValueException(sprintf(
                    'Could not mute value for attribute %s on store #%d',
                    $newValue->getAttributeCode(),
                    $newValue->getStoreId()
                ));
            }
        }

        $this->values->add($newValue);
    }

    /**
     * @param MediaGalleryAttributeInterface $attribute
     * @param int $storeId
     */
    public function getMediaGalleryFor(MediaGalleryAttributeInterface $attribute, $storeId)
    {
        // TODO: Implement getMediaGalleryFor() method.
    }
}