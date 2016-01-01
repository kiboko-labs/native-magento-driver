<?php

namespace Luni\Component\MagentoDriver\Model\Immutable;

use Doctrine\Common\Collections\ArrayCollection;
use League\Flysystem\File;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\ImageAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\ImageAttributeValueTrait;
use Luni\Component\MagentoDriver\Model\ImageMetadataAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\Mutable\MutableImageAttributeValue;

class ImmutableImageAttributeValue
    implements ImmutableAttributeValueInterface, ImageAttributeValueInterface
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
     * @return MutableImageAttributeValue
     */
    public function switchToMutable()
    {
        return MutableImageAttributeValue::buildNewWith(
            $this->attribute,
            $this->id,
            $this->file,
            $this->productId,
            $this->metadata->toArray()
        );
    }
}