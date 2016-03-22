<?php

namespace Luni\Component\MagentoDriver\Persister;

use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;

interface ProductPersisterInterface
{
    public function initialize();

    /**
     * @param ProductInterface $product
     */
    public function persist(ProductInterface $product);

    /**
     * @param ProductInterface $product
     */
    public function __invoke(ProductInterface $product);

    public function flush();
}
