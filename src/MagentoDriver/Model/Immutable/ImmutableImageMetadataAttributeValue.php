<?php

namespace Kiboko\Component\MagentoDriver\Model\Immutable;

use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeValueInterface;
use Kiboko\Component\MagentoDriver\Model\ImageMetadataAttributeValueInterface;
use Kiboko\Component\MagentoDriver\Model\ImageMetadataAttributeValueTrait;
use Kiboko\Component\MagentoDriver\Model\Mutable\MutableImageMetadataAttributeValue;
use Kiboko\Component\MagentoDriver\Model\ScopableAttributeValueInterface;

class ImmutableImageMetadataAttributeValue implements ImmutableAttributeValueInterface, ScopableAttributeValueInterface, ImageMetadataAttributeValueInterface
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
