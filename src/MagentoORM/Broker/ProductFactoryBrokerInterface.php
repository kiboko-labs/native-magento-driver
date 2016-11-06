<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Broker;

use Kiboko\Component\MagentoORM\Factory\ProductFactoryInterface;
use Kiboko\Component\MagentoORM\Matcher\ProductDataMatcherInterface;

interface ProductFactoryBrokerInterface
{
    /**
     * @param ProductFactoryInterface     $backend
     * @param ProductDataMatcherInterface $matcher
     */
    public function addFactory(
        ProductFactoryInterface $backend,
        ProductDataMatcherInterface $matcher
    );

    /**
     * @return \Generator|ProductFactoryInterface[]
     */
    public function walkFactoryList();

    /**
     * @param array $productData
     *
     * @return ProductFactoryInterface|null
     */
    public function findFor(array $productData);
}
