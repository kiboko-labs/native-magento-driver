<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Model\AttributeGroupInterface;

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
