<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Model\AttributeGroupInterface;

interface AttributeGroupFactoryInterface
{
    /**
     * @param array $options
     *
     * @return AttributeGroupInterface
     */
    public function buildNew(array $options);
}
