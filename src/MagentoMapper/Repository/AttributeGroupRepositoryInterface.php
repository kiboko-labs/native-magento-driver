<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoMapper\Repository;

interface AttributeGroupRepositoryInterface
{
    /**
     * @param string $groupCode
     * @param string $familyCode
     *
     * @return int
     */
    public function findOneByCode($groupCode, $familyCode);

    /**
     * @return int[]
     */
    public function findAll();
}
