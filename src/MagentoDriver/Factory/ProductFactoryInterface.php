<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Factory;

use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface;

interface ProductFactoryInterface
{
    /**
     * @param array  $options
     *
     * @return ProductInterface
     */
    public function buildNew(array $options);
}
