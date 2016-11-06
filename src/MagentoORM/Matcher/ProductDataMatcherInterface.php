<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Matcher;

interface ProductDataMatcherInterface
{
    /**
     * @param array $productData
     *
     * @return bool
     */
    public function match(array $productData);
}
