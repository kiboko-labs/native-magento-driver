<?php

namespace Kiboko\Component\MagentoDriver\Broker;

use Kiboko\Component\MagentoDriver\Matcher\AttributeValueMatcherInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Repository\ProductAttributeValueRepositoryInterface;

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
