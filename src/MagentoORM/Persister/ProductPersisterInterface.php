<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Persister;

use Kiboko\Component\MagentoORM\Entity\Product\ProductInterface;

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

    /**
     * @return \Traversable
     */
    public function flush();
}
