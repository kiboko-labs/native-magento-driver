<?php

namespace Luni\Component\MagentoDriver\Model;

use Doctrine\Common\Collections\Collection;
use League\Flysystem\File;

interface ImageAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return File
     */
    public function getFile();

    /**
     * @return Collection|ImageMetadataAttributeValueInterface[]
     */
    public function getMetadata();

    /**
     * @param int $storeId
     * @return ImageMetadataAttributeValueInterface|null
     */
    public function getMetadataForStoreId($storeId);
}
