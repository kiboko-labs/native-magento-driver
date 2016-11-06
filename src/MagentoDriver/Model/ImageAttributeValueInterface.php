<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Model;

use League\Flysystem\File;

interface ImageAttributeValueInterface extends AttributeValueInterface, MappableInterface
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
