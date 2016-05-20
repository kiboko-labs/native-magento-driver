<?php

namespace Luni\Component\MagentoDriver\Repository;

use Luni\Component\MagentoDriver\Model\AttributeOptionValueInterface;

interface AttributeOptionValueRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return AttributeOptionValueInterface
     */
    public function findOneById($id);
}
