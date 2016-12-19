<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Model\V1_9ce;

use Kiboko\Component\MagentoORM\Model\AttributeValueTrait as BaseAttributeValueTrait;

trait AttributeValueTrait
{
    use BaseAttributeValueTrait;

    /**
     * @return int
     */
    public function getEntityTypeId()
    {
        return $this->attribute->getEntityTypeId();
    }
}
