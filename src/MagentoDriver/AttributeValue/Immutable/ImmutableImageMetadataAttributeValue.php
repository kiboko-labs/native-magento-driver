<?php

namespace Luni\Component\MagentoDriver\AttributeValue\Immutable;

use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\AttributeValue\ImageMetadataAttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\ImageMetadataAttributeValueTrait;
use Luni\Component\MagentoDriver\AttributeValue\Mutable\MutableImageMetadataAttributeValue;

class ImmutableImageMetadataAttributeValue
    implements ImmutableAttributeValueInterface, ImageMetadataAttributeValueInterface
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
     * @return MutableImageMetadataAttributeValue
     */
    public function switchToMutable()
    {
        return MutableImageMetadataAttributeValue::buildNewWith(
            $this->attribute,
            $this->id,
            $this->label,
            $this->position,
            $this->excluded,
            $this->storeId
        );
    }
}