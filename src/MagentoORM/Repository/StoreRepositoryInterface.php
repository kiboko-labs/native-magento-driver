<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository;

use Kiboko\Component\MagentoORM\Model\StoreInterface;

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
