<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Model\AttributeOptionInterface;

interface AttributeOptionRepositoryInterface
{
    /**
     * @param int $identifier
     *
     * @return AttributeOptionInterface
     */
    public function findOneById($identifier);
}
