<?php

namespace Kiboko\Component\MagentoDriver\Broker;

use Kiboko\Component\MagentoDriver\Matcher\AttributeMatcherInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Repository\ProductAttributeValueRepositoryInterface;

interface ProductAttributeValueRepositoryBrokerInterface
{
    /**
     * @param ProductAttributeValueRepositoryInterface $repository
     * @param AttributeMatcherInterface           $matcher
     */
    public function addRepository(
        ProductAttributeValueRepositoryInterface $repository,
        AttributeMatcherInterface $matcher
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
