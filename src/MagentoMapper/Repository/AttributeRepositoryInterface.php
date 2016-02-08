<?php

namespace Luni\Component\MagentoMapper\Repository;

interface AttributeRepositoryInterface
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