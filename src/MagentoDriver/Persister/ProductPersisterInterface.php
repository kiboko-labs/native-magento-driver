<?php

namespace Luni\Component\MagentoDriver\Persister;

use Luni\Component\MagentoDriver\Entity\Product\ProductInterface;

interface ProductPersisterInterface
{
    /**
     * @return void
     */
    public function initialize();

    /**
     * @param ProductInterface $product
     */
    public function persist(ProductInterface $product);

    /**
     * @param ProductInterface $product
     */
    public function __invoke(ProductInterface $product);

    /**
     * @return void
     */
    public function flush();
}