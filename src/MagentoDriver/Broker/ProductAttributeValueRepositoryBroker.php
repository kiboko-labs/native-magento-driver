<?php

namespace Luni\Component\MagentoDriver\Broker;

use Closure;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Repository\ProductAttributeValueRepositoryInterface;

class ProductAttributeValueRepositoryBroker
    implements ProductAttributeValueRepositoryBrokerInterface
{
    /**
     * @var Collection|
     */
    private $repositories;

    /**
     * AttributePersisterBroker constructor.
     */
    public function __construct()
    {
        $this->repositories = new ArrayCollection();
    }

    /**
     * @param ProductAttributeValueRepositoryInterface $repository
     * @param Closure $matcher
     */
    public function addRepository(ProductAttributeValueRepositoryInterface $repository, Closure $matcher)
    {
        $this->repositories->add([
            'matcher'    => $matcher,
            'repository' => $repository
        ]);
    }

    /**
     * @return \Generator|ProductAttributeValueRepositoryInterface[]
     */
    public function walkRepositoryList()
    {
        foreach ($this->repositories as $repositoryInfo) {
            yield $repositoryInfo['matcher'] => $repositoryInfo['repository'];
        }
    }

    /**
     * @param AttributeInterface $attribute
     * @return ProductAttributeValueRepositoryInterface|null
     */
    public function findFor(AttributeInterface $attribute)
    {
        foreach ($this->walkRepositoryList() as $matcher => $repository) {
            if ($matcher($attribute) === true) {
                return $repository;
            }
        }

        return null;
    }
}