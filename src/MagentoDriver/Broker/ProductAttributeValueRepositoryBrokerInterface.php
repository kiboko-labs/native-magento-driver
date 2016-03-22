<?php

namespace Luni\Component\MagentoDriver\Broker;

use Luni\Component\MagentoDriver\Matcher\AttributeValueMatcherInterface;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Repository\ProductAttributeValueRepositoryInterface;

interface ProductAttributeValueRepositoryBrokerInterface
{
    /**
     * @param ProductAttributeValueRepositoryInterface $repository
     * @param AttributeValueMatcherInterface           $matcher
     */
    public function addRepository(
        ProductAttributeValueRepositoryInterface $repository,
        AttributeValueMatcherInterface $matcher
    );

    /**
     * @return \Generator|ProductAttributeValueRepositoryInterface[]
     */
    public function walkRepositoryList();

    /**
     * @param AttributeInterface $attribute
     *
     * @return ProductAttributeValueRepositoryInterface|null
     */
    public function findFor(AttributeInterface $attribute);
}
