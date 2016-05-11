<?php

namespace Luni\Component\MagentoDriver\Repository;

use Luni\Component\MagentoDriver\Model\AttributeGroupInterface;

interface AttributeGroupRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return AttributeGroupInterface
     */
    public function findOneById($id);

    /**
     * @param string $name
     *
     * @return AttributeGroupInterface
     */
    public function findOneByName($name);
}
