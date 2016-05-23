<?php

namespace Kiboko\Component\MagentoDriver\Broker;

use Kiboko\Component\MagentoDriver\Matcher\AttributeValueMatcherInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Repository\ProductAttributeValueRepositoryInterface;

class ProductAttributeValueRepositoryBroker implements ProductAttributeValueRepositoryBrokerInterface
{
    /**
     * @var \SplObjectStorage
     */
    private $repositories;

    /**
     * ProductAttributeValuePersisterBroker constructor.
     */
    public function __construct()
    {
        $this->repositories = new \SplObjectStorage();
    }

    /**
     * @param ProductAttributeValueRepositoryInterface $repository
     * @param AttributeValueMatcherInterface           $matcher
     */
    public function addRepository(
        ProductAttributeValueRepositoryInterface $repository,
        AttributeValueMatcherInterface $matcher
    ) {
        $this->repositories->attach($matcher, $repository);
    }

    /**
     * @return \Generator|ProductAttributeValueRepositoryInterface[]
     */
    public function walkRepositoryList()
    {
        foreach ($this->repositories as $matcher) {
            yield $matcher => $this->repositories[$matcher];
        }
    }

    /**
     * @param AttributeInterface $attribute
     *
     * @return ProductAttributeValueRepositoryInterface|null
     */
    public function findFor(AttributeInterface $attribute)
    {
        /**
         * @var AttributeValueMatcherInterface
         * @var ProductAttributeValueRepositoryInterface $repository
         */
        foreach ($this->walkRepositoryList() as $matcher => $repository) {
            if ($matcher->match($attribute) !== true) {
                continue;
            }

            return $repository;
        }

        return;
    }
}
