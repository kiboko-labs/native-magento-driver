<?php

namespace Kiboko\Component\MagentoDriver\Model\Immutable;

use Doctrine\Common\Collections\ArrayCollection;
use League\Flysystem\File;
use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Model\ImageAttributeValueInterface;
use Kiboko\Component\MagentoDriver\Model\ImageAttributeValueTrait;
use Kiboko\Component\MagentoDriver\Model\ImageMetadataAttributeValueInterface;
use Kiboko\Component\MagentoDriver\Model\Mutable\MutableImageAttributeValue;

class ImmutableImageAttributeValue implements ImmutableAttributeValueInterface, ImageAttributeValueInterface
{
    use ImageAttributeValueTrait;

    /**
     * DatetimeAttributeValueTrait constructor.
     *
     * @param AttributeInterface $attribute
     * @param File               $file
     * @param ProductInterface   $product
     * @param array              $metadata
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
     * @return MutableImageAttributeValue
     */
    public function switchToMutable()
    {
        return MutableImageAttributeValue::buildNewWith(
            $this->attribute,
            $this->id,
            $this->file,
            $this->product,
            $this->metadata->toArray()
        );
    }
}
