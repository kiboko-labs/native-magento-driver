<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Model\FamilyInterface;

interface FamilyRepositoryInterface
{
    /**
     * @param int $identifier
     *
     * @return FamilyInterface
     */
    public function findOneById($identifier);

    /**
     * @param string $name
     *
     * @return FamilyInterface
     */
    public function findOneByName($name);
}
