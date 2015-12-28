<?php

namespace Luni\Component\MagentoDriver\AttributeValue\Mutable;

use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\AttributeValue\ImageMetadataAttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\ImageMetadataAttributeValueTrait;
use Luni\Component\MagentoDriver\AttributeValue\Immutable\ImmutableImageMetadataAttributeValue;

class MutableImageMetadataAttributeValue
    implements MutableAttributeValueInterface, ImageMetadataAttributeValueInterface
{
    use ImageMetadataAttributeValueTrait;

    /**
     * DatetimeAttributeValueTrait constructor.
     * @param AttributeInterface $attribute
     * @param string $label
     * @param int $position
     * @param bool $excluded
     * @param null $storeId
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
}