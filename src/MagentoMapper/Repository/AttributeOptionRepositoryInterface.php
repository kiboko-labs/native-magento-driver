<?php

namespace Kiboko\Component\MagentoMapper\Repository;

interface AttributeOptionRepositoryInterface
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
