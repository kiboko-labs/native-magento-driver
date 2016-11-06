<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoMapper\Repository;

interface AttributeOptionValueRepositoryInterface
{
    /**
     * @param string $code
     * @param string $locale
     *
     * @return int
     */
    public function findOneByCodeAndLocale($code, $locale);

    /**
     * @return int[]
     */
    public function findAll();
}
