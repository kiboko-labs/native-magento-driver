<?php

namespace Luni\Component\MagentoDriver\Model;

interface ImageMetadataAttributeValueInterface extends AttributeValueInterface
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
