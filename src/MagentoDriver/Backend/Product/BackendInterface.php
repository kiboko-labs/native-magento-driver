<?php

namespace Luni\Component\MagentoDriver\Backend\Product;

use Luni\Component\MagentoDriver\Entity\ProductInterface;

interface BackendInterface
{
    /**
     * @param ProductInterface $product
     */
    public function persist(ProductInterface $product);

    /**
     * @return void
     */
    public function initialize();

    /**
     * @return void
     */
    public function flush();
}