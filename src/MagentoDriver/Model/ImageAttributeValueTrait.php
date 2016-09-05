<?php

namespace Kiboko\Component\MagentoDriver\Model;

use League\Flysystem\File;
use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;

trait ImageAttributeValueTrait
{
    use AttributeValueTrait;
    use MappableTrait;
    use IdentifiableTrait;

    /**
     * @var File
     */
    private $file;

    /**
     * @var \Traversable
     */
    private $metadata;

    /**
     * DatetimeAttributeValueTrait constructor.
     *
     * @param AttributeInterface $attribute
     * @param File               $file
     * @param ProductInterface   $product
     * @param array              $metadata
     */
    abstract public function __construct(
        AttributeInterface $attribute,
        File $file,
        ProductInterface $product = null,
        array $metadata = []
    );

    /**
     * @param AttributeInterface $attribute
     * @param int                $valueId
     * @param File               $file
     * @param ProductInterface   $product
     * @param array              $metadata
     *
     * @return ImageAttributeValueInterface
     */
    public static function buildNewWith(
        AttributeInterface $attribute,
        $valueId,
        File $file,
        ProductInterface $product = null,
        array $metadata
    ) {
        $object = new static($attribute, $file, $product, $metadata);

        $object->identifier = $valueId;

        return $object;
    }

    /**
     * @return bool
     */
    public function isScopable()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return clone $this->file;
    }

    /**
     * @return \Traversable|ImageMetadataAttributeValueInterface[]
     */
    public function getMetadata()
    {
        return clone $this->metadata;
    }

    /**
     * @param int $storeId
     *
     * @return ImageMetadataAttributeValueInterface|null
     */
    public function getMetadataForStoreId($storeId)
    {
        return $this->metadata->get($storeId);
    }
}
