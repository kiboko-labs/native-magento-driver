<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory;

use Kiboko\Component\MagentoORM\Model\EntityAttributeInterface;

interface EntityAttributeFactoryInterface
{
    /**
     * @param array $options
     *
     * @return EntityAttributeInterface
     */
    public function buildNew(array $options);
}
