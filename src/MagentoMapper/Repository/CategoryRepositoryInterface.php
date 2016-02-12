<?php

namespace Luni\Component\MagentoMapper\Repository;

interface CategoryRepositoryInterface
{
    /**
     * @param string $code
     * @return int
     */
    public function findOneByCode($code);

    /**
     * @return int[]
     */
    public function findAll();
}