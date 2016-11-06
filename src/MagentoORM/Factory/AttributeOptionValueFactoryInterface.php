<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory;

use Kiboko\Component\MagentoORM\Model\AttributeOptionValueInterface;

interface AttributeOptionValueFactoryInterface
{
    /**
     * @param array $options
     *
     * @return AttributeOptionValueInterface
     */
    public function buildNew(array $options);
}
