<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Broker;

use Kiboko\Component\MagentoORM\Factory\ProductFactoryInterface;
use Kiboko\Component\MagentoORM\Matcher\ProductDataMatcherInterface;
use Kiboko\Component\MagentoORM\Repository\ProductRepositoryInterface;

class ProductFactoryBroker implements ProductFactoryBrokerInterface
{
    /**
     * @var \SplObjectStorage
     */
    private $backends;

    /**
     * ProductAttributeValuePersisterBroker constructor.
     */
    public function __construct()
    {
        $this->backends = new \SplObjectStorage();
    }

    /**
     * @param ProductFactoryInterface     $backend
     * @param ProductDataMatcherInterface $matcher
     */
    public function addFactory(
        ProductFactoryInterface $backend,
        ProductDataMatcherInterface $matcher
    ) {
        $this->backends->attach($matcher, $backend);
    }

    /**
     * @return \Generator|ProductFactoryInterface[]
     */
    public function walkFactoryList()
    {
        foreach ($this->backends as $matcher) {
            yield $matcher => $this->backends[$matcher];
        }
    }

    /**
     * @param array $productData
     *
     * @return ProductFactoryInterface|null
     */
    public function findFor(array $productData)
    {
        /**
         * @var ProductDataMatcherInterface
         * @var ProductRepositoryInterface  $factory
         */
        foreach ($this->walkFactoryList() as $matcher => $factory) {
            if ($matcher->match($productData) !== true) {
                continue;
            }

            return $factory;
        }

        return;
    }
}
