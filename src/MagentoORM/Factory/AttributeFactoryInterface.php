<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory;

use Kiboko\Component\MagentoORM\Model\AttributeInterface;

interface AttributeFactoryInterface
{
    /**
     * @param array $options
     *
     * @return AttributeInterface
     */
    public function buildNew(array $options);
}
