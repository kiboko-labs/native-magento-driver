<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Broker;

use Kiboko\Component\MagentoDriver\Matcher\AttributeMatcherInterface;
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
     * @param AttributeMatcherInterface           $matcher
     */
    public function addRepository(
        ProductAttributeValueRepositoryInterface $repository,
        AttributeMatcherInterface $matcher
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
         * @var AttributeMatcherInterface
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
