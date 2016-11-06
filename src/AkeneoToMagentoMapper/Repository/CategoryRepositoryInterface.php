<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Repository;

interface CategoryRepositoryInterface
{
    /**
     * @param string $code
     *
     * @return int
     */
    public function findOneByCode($code);

    /**
     * @param string[] $codes
     *
     * @return int[]
     */
    public function findAllByCodes(array $codes);

    /**
     * @return int[]
     */
    public function findAll();
}
