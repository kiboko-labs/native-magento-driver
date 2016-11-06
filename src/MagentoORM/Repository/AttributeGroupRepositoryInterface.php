<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository;

use Kiboko\Component\MagentoORM\Model\AttributeGroupInterface;

interface AttributeGroupRepositoryInterface
{
    /**
     * @param int $identifier
     *
     * @return AttributeGroupInterface
     */
    public function findOneById($identifier);

    /**
     * @param string $name
     *
     * @return AttributeGroupInterface
     */
    public function findOneByName($name);
}
