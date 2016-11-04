<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

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
