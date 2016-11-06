<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory;

use Kiboko\Component\MagentoORM\Model\AttributeGroupInterface;

interface AttributeGroupFactoryInterface
{
    /**
     * @param array $options
     *
     * @return AttributeGroupInterface
     */
    public function buildNew(array $options);
}
