<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Factory;

use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;

interface ProductFactoryInterface
{
    /**
     * @param array $options
     *
     * @return ProductInterface
     */
    public function buildNew(array $options);
}
