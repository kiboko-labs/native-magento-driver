<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository;

use Kiboko\Component\MagentoORM\Model\AttributeLabelInterface;

interface AttributeLabelRepositoryInterface
{
    /**
     * @param int $identifier
     *
     * @return AttributeLabelInterface
     */
    public function findOneById($identifier);
}
