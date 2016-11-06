<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory;

use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Model\AttributeValueInterface;

interface AttributeValueFactoryInterface
{
    /**
     * @param AttributeInterface $attribute
     * @param array              $options
     *
     * @return AttributeValueInterface
     */
    public function buildNew(AttributeInterface $attribute, array $options);
}
