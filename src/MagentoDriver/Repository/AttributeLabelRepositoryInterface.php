<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Model\AttributeLabelInterface;

interface AttributeLabelRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return AttributeLabelInterface
     */
    public function findOneById($id);
}
