<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory;

use Kiboko\Component\MagentoORM\Model\FamilyInterface;

interface FamilyFactoryInterface
{
    /**
     * @param array $options
     *
     * @return FamilyInterface
     */
    public function buildNew(array $options);
}
