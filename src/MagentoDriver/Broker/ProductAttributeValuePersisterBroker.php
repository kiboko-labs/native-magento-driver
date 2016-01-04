<?php

namespace Luni\Component\MagentoDriver\Broker;

use Closure;
use Luni\Component\MagentoDriver\Matcher\AttributeValuePersisterMatcherInterface;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Persister\AttributeValue\AttributeValuePersisterInterface;

class ProductAttributeValuePersisterBroker
    implements ProductAttributeValuePersisterBrokerInterface
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
     * @param AttributeValuePersisterInterface $backend
     * @param AttributeValuePersisterMatcherInterface $matcher
     */
    public function addPersister(
        AttributeValuePersisterInterface $backend,
        AttributeValuePersisterMatcherInterface $matcher
    ) {
        $this->backends->attach($matcher, $backend);
    }

    /**
     * @return \Generator|AttributeValuePersisterInterface[]
     */
    public function walkPersisterList()
    {
        foreach ($this->backends as $matcher) {
            yield $matcher => $this->backends[$matcher];
        }
    }

    /**
     * @param AttributeInterface $attribute
     * @return AttributeValuePersisterInterface|null
     */
    public function findFor(AttributeInterface $attribute)
    {
        /**
         * @var AttributeValuePersisterMatcherInterface $matcher
         * @var AttributeValuePersisterInterface $backend
         */
        foreach ($this->walkPersisterList() as $matcher => $backend) {
            if ($matcher->match($attribute) !== true) {
                continue;
            }

            return $backend;
        }

        return null;
    }
}