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
     * @param string[] $codes
     * @return int[]
     */
    public function findAllByCodes(array $codes);

    /**
     * @return int[]
     */
    public function findAll();
}