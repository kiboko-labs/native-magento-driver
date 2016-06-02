<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Model\AttributeGroupInterface;

interface AttributeGroupRepositoryInterface
{
    /**
     * @param int $identifier
     *
     * @return AttributeGroupInterface
     */
    public function findOneById($identifier);

    /**
     * @param string $name
     *
     * @return AttributeGroupInterface
     */
    public function findOneByName($name);
}
