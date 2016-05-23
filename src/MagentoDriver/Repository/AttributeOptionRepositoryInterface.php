<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Model\AttributeOptionInterface;

interface AttributeOptionRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return AttributeOptionInterface
     */
    public function findOneById($id);
}
