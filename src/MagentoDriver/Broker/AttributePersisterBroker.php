<?php

namespace Luni\Component\MagentoDriver\Broker;

use Closure;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\Persister\AttributeValue\PersisterInterface;

class AttributePersisterBroker
    implements AttributePersisterBrokerInterface
{
    /**
     * @var Collection
     */
    private $backends;

    /**
     * AttributePersisterBroker constructor.
     */
    public function __construct()
    {
        $this->backends = new ArrayCollection();
    }

    /**
     * @param PersisterInterface $backend
     * @param Closure $matcher
     */
    public function addPersister(PersisterInterface $backend, Closure $matcher)
    {
        $this->backends->add([
            'matcher' => $matcher,
            'persister' => $backend
        ]);
    }

    /**
     * @return \Generator|PersisterInterface[]
     */
    public function walkPersisterList()
    {
        foreach ($this->backends as $backendInfo) {
            yield $backendInfo['matcher'] => $backendInfo['persister'];
        }
    }

    /**
     * @param AttributeInterface $attribute
     * @return PersisterInterface|null
     */
    public function findFor(AttributeInterface $attribute)
    {
        foreach ($this->walkPersisterList() as $matcher => $backend) {
            if ($matcher($attribute) === true) {
                return $backend;
            }
        }

        return null;
    }
}