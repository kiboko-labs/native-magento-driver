<?php

namespace Kiboko\Component\MagentoDriver\Repository;

use Kiboko\Component\MagentoDriver\Model\EntityStoreInterface;

interface EntityStoreRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return EntityStoreInterface
     */
    public function findOneById($id);

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
     * @return Collection|EntityStoreInterface[]
     */
    public function findAll();
}
