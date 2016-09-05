<?php

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
