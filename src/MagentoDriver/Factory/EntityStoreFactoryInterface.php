<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Model\EntityStoreInterface;

interface EntityStoreFactoryInterface
{
    /**
     * @param array $options
     *
     * @return EntityStoreInterface
     */
    public function buildNew(array $options);
}
