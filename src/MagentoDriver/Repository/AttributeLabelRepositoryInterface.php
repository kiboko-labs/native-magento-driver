<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Model\AttributeLabelInterface;

interface AttributeLabelRepositoryInterface
{
    /**
     * @param int $identifier
     *
     * @return AttributeLabelInterface
     */
    public function findOneById($identifier);
}
