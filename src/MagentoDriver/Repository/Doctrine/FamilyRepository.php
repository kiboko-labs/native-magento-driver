<?php

namespace Luni\Component\MagentoDriver\Repository\Doctrine;

use Luni\Component\MagentoDriver\Family\Family;
use Luni\Component\MagentoDriver\Family\FamilyInterface;
use Luni\Component\MagentoDriver\Repository\FamilyRepositoryInterface;

class FamilyRepository
    implements FamilyRepositoryInterface
{
    /**
     * @param int $id
     * @return FamilyInterface
     */
    public function findOneById($id)
    {
        return new Family('Default');
    }
}