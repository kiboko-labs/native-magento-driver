<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model\V1_9ce;

use Kiboko\Component\MagentoORM\Model\AttributeValueInterface as BaseAttributeValueInterface;

interface AttributeValueInterface extends BaseAttributeValueInterface
{
    /**
     * @return int
     */
    public function getEntityTypeId();
}
