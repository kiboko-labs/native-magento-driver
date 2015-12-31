<?php

namespace Luni\Component\MagentoDriver\Broker;

use Closure;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Repository\ProductAttributeValueRepositoryInterface;

interface ProductAttributeValueRepositoryBrokerInterface
{
    /**
     * @param ProductAttributeValueRepositoryInterface $repository
     * @param Closure $matcher
     */
    public function addRepository(ProductAttributeValueRepositoryInterface $repository, Closure $matcher);

    /**
     * @return \Generator|ProductAttributeValueRepositoryInterface[]
     */
    public function walkRepositoryList();

    /**
     * @param AttributeInterface $attribute
     * @return ProductAttributeValueRepositoryInterface|null
     */
    public function findFor(AttributeInterface $attribute);
}