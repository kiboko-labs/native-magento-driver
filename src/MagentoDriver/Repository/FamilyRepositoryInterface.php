<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Model\FamilyInterface;

interface FamilyRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return FamilyInterface
     */
    public function findOneById($id);

    /**
     * @param string $name
     *
     * @return FamilyInterface
     */
    public function findOneByName($name);
}
