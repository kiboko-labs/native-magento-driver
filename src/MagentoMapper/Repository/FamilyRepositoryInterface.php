<?php

namespace Kiboko\Component\MagentoMapper\Repository;

interface FamilyRepositoryInterface
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
