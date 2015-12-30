<?php

namespace Luni\Component\MagentoDriver\AttributeValue\Mutable;

use Doctrine\Common\Collections\ArrayCollection;
use League\Flysystem\File;
use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\AttributeValue\ImageAttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\ImageAttributeValueTrait;
use Luni\Component\MagentoDriver\AttributeValue\ImageMetadataAttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\Immutable\ImmutableImageAttributeValue;

class MutableImageAttributeValue
    implements MutableAttributeValueInterface, ImageAttributeValueInterface
{
    use ImageAttributeValueTrait;

    /**
     * DatetimeAttributeValueTrait constructor.
     * @param AttributeInterface $attribute
     * @param File $file
     * @param int $productId
     * @param array $metadata
     */
    public function __construct(
        AttributeInterface $attribute,
        File $file,
        $productId = null,
        array $metadata = []
    ) {
        $this->attribute = $attribute;
        $this->file = $file;
        $this->productId = $productId;

        $this->metadata = new ArrayCollection();
        foreach ($metadata as $meta) {
            if (!$meta instanceof ImageMetadataAttributeValueInterface) {
                continue;
            }

            $this->metadata->set($meta->getStoreId(), $meta);
        }
    }

    /**
     * @param File $file
     */
    public function setFile(File $file)
    {
        $this->file = $file;
    }

    /**
     * @param ImageMetadataAttributeValueInterface $metadata
     */
    public function addMetadata(ImageMetadataAttributeValueInterface $metadata)
    {
        $this->metadata->set($metadata->getStoreId(), $metadata);
    }

    /**
     * @return ImmutableImageAttributeValue
     */
    public function switchToImmutable()
    {
        return ImmutableImageAttributeValue::buildNewWith(
            $this->attribute,
            $this->id,
            $this->file,
            $this->productId,
            $this->metadata->toArray()
        );
    }
}