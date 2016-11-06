<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Model\EntityTypeInterface;

interface EntityTypeFactoryInterface
{
    /**
     * @param array $options
     *
     * @return EntityTypeInterface
     */
    public function buildNew(array $options);
}
