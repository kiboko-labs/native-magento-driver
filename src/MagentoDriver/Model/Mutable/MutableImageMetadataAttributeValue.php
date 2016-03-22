<?php

namespace Luni\Component\MagentoDriver\Model\Mutable;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Model\ImageMetadataAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\ImageMetadataAttributeValueTrait;
use Luni\Component\MagentoDriver\Model\Immutable\ImmutableImageMetadataAttributeValue;
use Luni\Component\MagentoDriver\Model\ScopableAttributeValueInterface;

class MutableImageMetadataAttributeValue implements MutableAttributeValueInterface, ScopableAttributeValueInterface, ImageMetadataAttributeValueInterface
{
    use ImageMetadataAttributeValueTrait;

    /**
     * DatetimeAttributeValueTrait constructor.
     *
     * @param AttributeInterface $attribute
     * @param string             $label
     * @param int                $position
     * @param bool               $excluded
     * @param null               $storeId
     */
    public function __construct(
        AttributeInterface $attribute,
        $label,
        $position,
        $excluded = false,
        $storeId = null
    ) {
        $this->attribute = $attribute;
        $this->label = $label;
        $this->position = (int) $position;
        $this->excluded = (bool) $excluded;
        $this->storeId = (int) $storeId;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @param bool $excluded
     */
    public function setExcluded($excluded)
    {
        $this->excluded = $excluded;
    }

    /**
     * @return ImmutableImageMetadataAttributeValue
     */
    public function switchToImmutable()
    {
        return ImmutableImageMetadataAttributeValue::buildNewWith(
            $this->attribute,
            $this->id,
            $this->label,
            $this->position,
            $this->excluded,
            $this->storeId
        );
    }

    /**
     * @param $storeId
     *
     * @return AttributeValueInterface
     */
    public function copyToStoreId($storeId)
    {
        return static::buildNewWith(
            $this->attribute,
            $this->id,
            $this->label,
            $this->position,
            $this->excluded,
            $storeId
        );
    }
}
