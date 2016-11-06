<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\Transformer;

use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface as KibokoProductInterface;
use Pim\Component\Catalog\Model\ProductInterface as PimProductInterface;

interface ProductTransformerInterface
{
    /**
     * @param PimProductInterface $product
     *
     * @return KibokoProductInterface[]
     */
    public function transform(PimProductInterface $product);

    /**
     * @param PimProductInterface $product
     *
     * @return bool
     */
    public function supportsTransformation(PimProductInterface $product);
}
