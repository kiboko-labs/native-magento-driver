<?php

namespace Luni\Component\MagentoDriver\Broker;

use Closure;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Persister\AttributeValue\PersisterInterface;

class AttributePersisterBroker
    implements AttributePersisterBrokerInterface
{
    /**
     * @var \SplObjectStorage
     */
    private $backends;

    /**
     * AttributePersisterBroker constructor.
     */
    public function __construct()
    {
        $this->backends = new \SplObjectStorage();
    }

    /**
     * @param PersisterInterface $backend
     * @param Closure $matcher
     */
    public function addPersister(PersisterInterface $backend, Closure $matcher)
    {
        $this->backends->attach($matcher, $backend);
    }

    /**
     * @return \Generator|PersisterInterface[]
     */
    public function walkPersisterList()
    {
        foreach ($this->backends as $matcher) {
            yield $matcher => $this->backends[$matcher];
        }
    }

    /**
     * @param AttributeInterface $attribute
     * @return PersisterInterface|null
     */
    public function findFor(AttributeInterface $attribute)
    {
        /**
         * @var Closure $matcher
         * @var PersisterInterface $backend
         */
        foreach ($this->walkPersisterList() as $matcher => $backend) {
            if ($matcher($attribute) !== true) {
                continue;
            }

            return $backend;
        }

        return null;
    }
}