<?php

namespace Kiboko\Component\MagentoMapper\Transformer;

use Kiboko\Component\MagentoDriver\Entity\Product\ProductInterface as KibokoProductInterface;
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