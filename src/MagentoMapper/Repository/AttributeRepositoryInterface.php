<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoMapper\Repository;

interface AttributeRepositoryInterface
{
    /**
     * @param string $code
     *
     * @return int
     */
    public function findOneByCode($code);

    /**
     * @return int[]
     */
    public function findAll();
}
