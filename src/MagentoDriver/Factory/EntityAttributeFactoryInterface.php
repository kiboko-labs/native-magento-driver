<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Model\EntityAttributeInterface;

interface EntityAttributeFactoryInterface
{
    /**
     * @param array $options
     *
     * @return EntityAttributeInterface
     */
    public function buildNew(array $options);
}
