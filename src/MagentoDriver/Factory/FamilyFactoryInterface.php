<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Model\FamilyInterface;

interface FamilyFactoryInterface
{
    /**
     * @param array $options
     *
     * @return FamilyInterface
     */
    public function buildNew(array $options);
}
