<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model\Magento20\Mutable;

use Doctrine\Common\Collections\ArrayCollection;
use Kiboko\Component\MagentoORM\Model\ImmutableAttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\MutableAttributeValueInterface;
use League\Flysystem\File;
use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\ImageAttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\ImageAttributeValueTrait;
use Kiboko\Component\MagentoORM\Model\ImageMetadataAttributeValueInterface;
use Kiboko\Component\MagentoORM\Model\Magento20\Immutable\ImmutableImageAttributeValue;

class MutableImageAttributeValue implements MutableAttributeValueInterface, ImageAttributeValueInterface
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
     * @return ImageAttributeValueInterface|ImmutableAttributeValueInterface
     */
    public function switchToImmutable()
    {
        return ImmutableImageAttributeValue::buildNewWith(
            $this->identifier,
            $this->attribute,
            $this->file,
            $this->product,
            $this->metadata->toArray()
        );
    }
}
