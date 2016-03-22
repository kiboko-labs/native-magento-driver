<?php

namespace Luni\Component\MagentoDriver\Repository;

use Luni\Component\MagentoDriver\Model\FamilyInterface;

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
