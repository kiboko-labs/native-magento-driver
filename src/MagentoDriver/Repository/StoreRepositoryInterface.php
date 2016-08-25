<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Model\StoreInterface;

interface StoreRepositoryInterface
{
    /**
     * @param int $identifier
     *
     * @return StoreInterface
     */
    public function findOneById($identifier);

    /**
     * @param string $code
     *
     * @return StoreInterface
     */
    public function findOneByCode($code);

    /**
     * @return \Traversable|StoreInterface[]
     */
    public function findAll();
}
