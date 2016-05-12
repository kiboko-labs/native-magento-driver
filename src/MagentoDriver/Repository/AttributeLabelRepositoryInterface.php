<?php

namespace Luni\Component\MagentoDriver\Repository;

use Luni\Component\MagentoDriver\Model\AttributeLabelInterface;

interface AttributeLabelRepositoryInterface
{

    /**
     * @param int $id
     *
     * @return AttributeLabelInterface
     */
    public function findOneById($id);
}
