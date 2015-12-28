<?php

namespace Luni\Component\MagentoDriver\AttributeValue\Immutable;

use Doctrine\Common\Collections\ArrayCollection;
use League\Flysystem\File;
use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\AttributeValue\ImageAttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\ImageAttributeValueTrait;
use Luni\Component\MagentoDriver\AttributeValue\ImageMetadataAttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\Mutable\MutableImageAttributeValue;

class ImmutableImageAttributeValue
    implements ImmutableAttributeValueInterface, ImageAttributeValueInterface
{
    use ImageAttributeValueTrait;

    /**
     * DatetimeAttributeValueTrait constructor.
     * @param AttributeInterface $attribute
     * @param array $metadata
     * @param File $file
     */
    public function __construct(
        AttributeInterface $attribute,
        File $file,
        array $metadata = []
    ) {
        $this->attribute = $attribute;
        $this->file = $file;

        $this->metadata = new ArrayCollection();
        foreach ($metadata as $meta) {
            if (!$meta instanceof ImageMetadataAttributeValueInterface) {
                continue;
            }

            $this->metadata->set($meta->getStoreId(), $meta);
        }
    }

    /**
     * @return MutableImageAttributeValue
     */
    public function switchToMutable()
    {
        return MutableImageAttributeValue::buildNewWith(
            $this->attribute,
            $this->id,
            $this->file,
            $this->metadata->toArray()
        );
    }
}