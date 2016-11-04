<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Model\AttributeOptionValueInterface;

interface AttributeOptionValueFactoryInterface
{
    /**
     * @param array $options
     *
     * @return AttributeOptionValueInterface
     */
    public function buildNew(array $options);
}
