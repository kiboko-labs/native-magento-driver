<?php

namespace Luni\Component\MagentoDriver\Model\Mutable;

use Doctrine\Common\Collections\ArrayCollection;
use League\Flysystem\File;
use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Model\ImageAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\ImageAttributeValueTrait;
use Luni\Component\MagentoDriver\Model\ImageMetadataAttributeValueInterface;
use Luni\Component\MagentoDriver\Model\Immutable\ImmutableImageAttributeValue;

class MutableImageAttributeValue
    implements MutableAttributeValueInterface, ImageAttributeValueInterface
{
    use ImageAttributeValueTrait;

    /**
     * DatetimeAttributeValueTrait constructor.
     * @param AttributeInterface $attribute
     * @param File $file
     * @param ProductInterface $product
     * @param array $metadata
     */
    public function __construct(
        AttributeInterface $attribute,
        File $file,
        ProductInterface $product = null,
        array $metadata = []
    ) {
        $this->attribute = $attribute;
        $this->file = $file;
        if ($product !== null) {
            $this->attachToProduct($product);
        }

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
            $this->product,
            $this->metadata->toArray()
        );
    }
}
