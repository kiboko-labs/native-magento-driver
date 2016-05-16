<?php

namespace Luni\Component\MagentoDriver\Repository;

use Luni\Component\MagentoDriver\Model\AttributeOptionInterface;

interface AttributeOptionRepositoryInterface
{

    /**
     * @param int $id
     *
     * @return AttributeOptionInterface
     */
    public function findOneById($id);
}
