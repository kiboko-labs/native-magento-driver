<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Repository;

use Kiboko\Component\MagentoORM\Model\AttributeOptionValueInterface;

interface AttributeOptionValueRepositoryInterface
{
    /**
     * @param int $identifier
     *
     * @return AttributeOptionValueInterface
     */
    public function findOneById($identifier);
}
