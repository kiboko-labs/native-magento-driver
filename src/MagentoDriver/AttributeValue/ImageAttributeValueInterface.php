<?php

namespace Luni\Component\MagentoDriver\AttributeValue;

interface ImageAttributeValueInterface
    extends AttributeValueInterface
{
    /**
     * @return \SplFileInfo
     */
    public function getFile();

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