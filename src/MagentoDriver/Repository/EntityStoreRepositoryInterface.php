<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Model\EntityStoreInterface;

interface EntityStoreRepositoryInterface
{
    /**
     * @param int $identifier
     *
     * @return EntityStoreInterface
     */
    public function findOneById($identifier);

    /**
     * @param string $storeId
     *
     * @return EntityStoreInterface
     */
    public function findOneByStoreId($storeId);

    /**
     * @param string $typeId
     *
     * @return EntityStoreInterface
     */
    public function findOneByTypeId($typeId);

    /**
     * @return \Traversable|EntityStoreInterface[]
     */
    public function findAll();
}
