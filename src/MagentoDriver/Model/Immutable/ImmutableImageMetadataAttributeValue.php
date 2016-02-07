<?php

namespace Luni\Component\MagentoDriver\Model\Immutable;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Model\ImageMetadataAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\ImageMetadataAttributeValueTrait;
use Luni\Component\MagentoDriver\Model\Mutable\MutableImageMetadataAttributeValue;
use Luni\Component\MagentoDriver\Model\ScopableAttributeValueInterface;

class ImmutableImageMetadataAttributeValue
    implements ImmutableAttributeValueInterface, ScopableAttributeValueInterface, ImageMetadataAttributeValueInterface
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

    /**
     * @param $storeId
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
