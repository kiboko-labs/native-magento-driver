<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

use League\Flysystem\File;
use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;

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
     * @param int                $valueId
     * @param AttributeInterface $attribute
     * @param File               $file
     * @param ProductInterface   $product
     * @param array              $metadata
     *
     * @return ImageAttributeValueInterface
     */
    public static function buildNewWith(
        $valueId,
        AttributeInterface $attribute,
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
