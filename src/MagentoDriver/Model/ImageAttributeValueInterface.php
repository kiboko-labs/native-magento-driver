<?php

namespace Kiboko\Component\MagentoDriver\Model;

use League\Flysystem\File;

interface ImageAttributeValueInterface extends AttributeValueInterface
{
    /**
     * @return File
     */
    public function getFile();

    /**
     * @return \Traversable|ImageMetadataAttributeValueInterface[]
     */
    public function getMetadata();

    /**
     * @param int $storeId
     *
     * @return ImageMetadataAttributeValueInterface|null
     */
    public function getMetadataForStoreId($storeId);
}
