<?php

namespace Luni\Component\MagentoDriver\Persister\Product;

use Luni\Component\MagentoDriver\Entity\ProductInterface;

interface PersisterInterface
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
     * @return void
     */
    public function flush();
}