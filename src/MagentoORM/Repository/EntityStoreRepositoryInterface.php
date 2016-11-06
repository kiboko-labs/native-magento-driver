<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository;

use Kiboko\Component\MagentoORM\Model\EntityStoreInterface;

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
