<?php

namespace Luni\Component\MagentoDriver\Model;

use League\Flysystem\File;

interface ImageMetadataAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return string
     */
    public function getLabel();

    /**
     * @return int
     */
    public function getPosition();

    /**
     * @return bool
     */
    public function isExcluded();
}