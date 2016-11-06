<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository;

use Kiboko\Component\MagentoORM\Model\AttributeOptionInterface;

interface AttributeOptionRepositoryInterface
{
    /**
     * @param int $identifier
     *
     * @return AttributeOptionInterface
     */
    public function findOneById($identifier);
}
