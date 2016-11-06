<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Entity\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoORM\Exception\RuntimeErrorException;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\MediaGalleryAttributeInterface;
use Kiboko\Component\MagentoORM\Model\AttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\Immutable\ImmutableAttributeValueInterface;
use Kiboko\Component\MagentoORM\Exception\ImmutableValueException;
use Kiboko\Component\MagentoORM\Model\FamilyInterface;
use Kiboko\Component\MagentoORM\Model\Mutable\MutableAttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\ScopableAttributeValueInterface;

trait BaseProductTrait
{
    /**
     * @var int
     */
    private $identifier;

    /**
     * @var string
     */
    private $stringIdentifier;

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
     * @var int
     */
    private $visibility;

    /**
     * @var \DateTimeInterface
     */
    private $creationDate;

    /**
     * @var \DateTimeInterface
     */
    private $modificationDate;

    /**
     * @param \DateTimeInterface|null $dateTime
     *
     * @return \DateTimeImmutable|\DateTimeInterface
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    private function initializeDate(\DateTimeInterface $dateTime = null)
    {
        if ($dateTime === null) {
            return new \DateTimeImmutable();
        }
        if ($dateTime instanceof \DateTime) {
            return \DateTimeImmutable::createFromMutable($dateTime);
        }

        return $dateTime;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->identifier;
    }

    /**
     * @param int $identifier
     *
     * @return ProductInterface
     */
    public function persistedToId($identifier)
    {
        if ($this->identifier !== null) {
            throw new RuntimeErrorException('Product ID is immutable once set.');
        }
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->stringIdentifier;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->productType;
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
     * @return int
     */
    public function getFamilyId()
    {
        if ($this->getFamily() === null) {
            return;
        }

        return $this->getFamily()->getId();
    }

    /**
     * @param FamilyInterface $family
     */
    public function changeFamily(FamilyInterface $family)
    {
        $this->family = $family;
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
     * @return bool
     */
    public function isNotVisible()
    {
        return $this->visibility === ProductInterface::VISIBILITY_NOT_VISIBLE;
    }

    /**
     * @return bool
     */
    public function isVisibleInCatalog()
    {
        return $this->visibility === ProductInterface::VISIBILITY_IN_CATALOG ||
            $this->visibility === ProductInterface::VISIBILITY_BOTH
        ;
    }

    /**
     * @return bool
     */
    public function isVisibleInSearch()
    {
        return $this->visibility === ProductInterface::VISIBILITY_IN_SEARCH ||
            $this->visibility === ProductInterface::VISIBILITY_BOTH
        ;
    }

    /**
     * @return bool
     */
    public function isVisibleInCatalogAndSearch()
    {
        return $this->visibility === ProductInterface::VISIBILITY_BOTH;
    }

    /**
     * @return bool
     */
    public function isVisibleSomewhere()
    {
        return $this->visibility === ProductInterface::VISIBILITY_IN_CATALOG ||
            $this->visibility === ProductInterface::VISIBILITY_IN_SEARCH ||
            $this->visibility === ProductInterface::VISIBILITY_BOTH
        ;
    }

    public function setNotVisible()
    {
        $this->visibility = ProductInterface::VISIBILITY_NOT_VISIBLE;
    }

    public function setVisibleInCatalog()
    {
        $this->visibility = ProductInterface::VISIBILITY_IN_CATALOG;
    }

    public function setVisibleInSearch()
    {
        $this->visibility = ProductInterface::VISIBILITY_IN_SEARCH;
    }

    public function setVisibleInCatalogAndSearch()
    {
        $this->visibility = ProductInterface::VISIBILITY_BOTH;
    }

    /**
     * @param AttributeInterface $attribute
     * @param int                $storeId
     *
     * @return bool
     */
    public function hasValueFor(AttributeInterface $attribute, $storeId = null)
    {
        /** @var AttributeValueInterface $value */
        foreach ($this->values as $value) {
            if ($value->getAttributeCode() !== $attribute->getCode()) {
                continue;
            }

            if ($value instanceof ScopableAttributeValueInterface) {
                if ($value->getStoreId() === $storeId) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param AttributeInterface $attribute
     * @param int                $storeId
     *
     * @return ImmutableAttributeValueInterface
     */
    public function getValueFor(AttributeInterface $attribute, $storeId = null)
    {
        return $this->getValueByAttributeCode($attribute->getCode(), $storeId);
    }

    /**
     * @param string $attributeCode
     * @param int    $storeId
     *
     * @return ImmutableAttributeValueInterface
     */
    public function getValueByAttributeCode($attributeCode, $storeId = null)
    {
        $defaultValue = null;

        /** @var AttributeValueInterface $value */
        foreach ($this->values as $value) {
            if ($value->getAttributeCode() !== $attributeCode) {
                continue;
            }

            if ($value instanceof ScopableAttributeValueInterface) {
                if ($value->getStoreId() === $storeId) {
                    return $value;
                }

                if ($storeId !== 0 && $value->getStoreId() === 0) {
                    $defaultValue = $value;
                }
            }
        }

        return $defaultValue;
    }

    /**
     * @param AttributeInterface $attribute
     * @param int                $storeId
     *
     * @return ImmutableAttributeValueInterface
     */
    public function getImmutableValueFor(AttributeInterface $attribute, $storeId)
    {
        $this->getImmutableValueByAttributeCode($attribute->getCode(), $storeId);
    }

    /**
     * @param string $attributeCode
     * @param int    $storeId
     *
     * @return ImmutableAttributeValueInterface
     */
    public function getImmutableValueByAttributeCode($attributeCode, $storeId)
    {
        $attributeValue = $this->getValueByAttributeCode($attributeCode, $storeId);

        if ($attributeValue instanceof ImmutableAttributeValueInterface) {
            return $attributeValue;
        } elseif ($attributeValue instanceof MutableAttributeValueInterface) {
            return $attributeValue->switchToImmutable();
        }

        throw new RuntimeErrorException('Invalid value type');
    }

    /**
     * @param AttributeInterface $attribute
     * @param int                $storeId
     *
     * @return MutableAttributeValueInterface
     */
    public function getMutableValueFor(AttributeInterface $attribute, $storeId)
    {
        return $this->getMutableValueByAttributeCode($attribute->getCode(), $storeId);
    }

    /**
     * @param string $attributeCode
     * @param int    $storeId
     *
     * @return MutableAttributeValueInterface
     */
    public function getMutableValueByAttributeCode($attributeCode, $storeId)
    {
        $attributeValue = $this->getValueByAttributeCode($attributeCode, $storeId);

        if ($attributeValue === null) {
            return;
        }

        if ($attributeValue instanceof MutableAttributeValueInterface) {
            return $attributeValue;
        } elseif ($attributeValue instanceof ImmutableAttributeValueInterface) {
            return $attributeValue->switchToMutable();
        }

        throw new RuntimeErrorException('Invalid value type');
    }

    /**
     * @param AttributeInterface $attribute
     *
     * @return Collection|AttributeValueInterface[]
     */
    public function getAllValuesFor(AttributeInterface $attribute)
    {
        return $this->getAllValuesByAttributeCode($attribute->getCode());
    }

    /**
     * @param string $attributeCode
     *
     * @return Collection|AttributeValueInterface[]
     */
    public function getAllValuesByAttributeCode($attributeCode)
    {
        $collection = new ArrayCollection();
        /** @var AttributeValueInterface $value */
        foreach ($this->values as $value) {
            if ($value->getAttributeCode() !== $attributeCode) {
                continue;
            }

            if ($value instanceof ScopableAttributeValueInterface) {
                $collection->set($value->getStoreId(), $value);
            } else {
                $collection->add(0, $value);
                break;
            }
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

        $newValue->attachToProduct($this);
        $this->values->add($newValue);
    }

    /**
     * @param MediaGalleryAttributeInterface $attribute
     * @param int                            $storeId
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
        return false;
    }

    /**
     * return Collection.
     */
    public function getRequiredOptions()
    {
        return new ArrayCollection();
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getModificationDate()
    {
        return $this->modificationDate;
    }
}
