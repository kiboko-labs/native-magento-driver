<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Model\AttributeOptionValueInterface;

interface AttributeOptionValueRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return AttributeOptionValueInterface
     */
    public function findOneById($id);
}
