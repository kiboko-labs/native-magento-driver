<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Model\AttributeOptionValueInterface;

interface AttributeOptionValueRepositoryInterface
{
    /**
     * @param int $identifier
     *
     * @return AttributeOptionValueInterface
     */
    public function findOneById($identifier);
}
