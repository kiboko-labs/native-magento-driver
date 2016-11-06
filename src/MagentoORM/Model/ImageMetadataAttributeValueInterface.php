<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model;

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
