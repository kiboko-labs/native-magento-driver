<?php

namespace Luni\Component\MagentoDriver\Entity\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\MediaGalleryAttributeInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Model\Immutable\ImmutableAttributeValueInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\Exception\ImmutableValueException;
use Luni\Component\MagentoDriver\Model\FamilyInterface;

trait BaseProductTrait
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
     * @var string
     */
    private $productType;

    /**
     * @var \DateTimeInterface
     */
    private $creationDate;

    /**
     * @var \DateTimeInterface
     */
    private $modificationDate;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    abstract public function getType();

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
     * @param AttributeInterface $attribute
     * @return Collection|AttributeValueInterface[]
     */
    public function getAllValuesFor(AttributeInterface $attribute)
    {
        $collection = new ArrayCollection();
        /** @var AttributeValueInterface $value */
        foreach ($this->values as $value) {
            if ($value->getAttributeCode() !== $attribute->getCode()) {
                continue;
            }

            $collection->set($value->getStoreId(), $value);
        }

        return $collection;
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

    /**
     * @return bool
     */
    public function hasOptions()
    {
        // TODO: Implement hasOptions() method.
    }

    public function getRequiredOptions()
    {
        // TODO: Implement getRequiredOptions() method.
    }

    public function getCreationDate()
    {
        // TODO: Implement getCreationDate() method.
    }

    public function getModificationDate()
    {
        // TODO: Implement getModificationDate() method.
    }
}