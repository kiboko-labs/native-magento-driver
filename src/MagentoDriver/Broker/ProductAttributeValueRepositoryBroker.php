<?php

namespace Luni\Component\MagentoDriver\Broker;

use Closure;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Repository\ProductAttributeValueRepositoryInterface;

class ProductAttributeValueRepositoryBroker
    implements ProductAttributeValueRepositoryBrokerInterface
{
    /**
     * @var \SplObjectStorage
     */
    private $repositories;

    /**
     * AttributePersisterBroker constructor.
     */
    public function __construct()
    {
        $this->repositories = new \SplObjectStorage();
    }

    /**
     * @param ProductAttributeValueRepositoryInterface $repository
     * @param Closure $matcher
     */
    public function addRepository(ProductAttributeValueRepositoryInterface $repository, Closure $matcher)
    {
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
     * @return ProductAttributeValueRepositoryInterface|null
     */
    public function findFor(AttributeInterface $attribute)
    {
        /**
         * @var Closure $matcher
         * @var ProductAttributeValueRepositoryInterface $repository
         */
        foreach ($this->walkRepositoryList() as $matcher => $repository) {
            if ($matcher($attribute) !== true) {
                continue;
            }

            return $repository;
        }

        return null;
    }
}