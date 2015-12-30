<?php

namespace Luni\Component\MagentoDriver\Broker;

use Closure;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Persister\AttributeValue\PersisterInterface;

interface AttributePersisterBrokerInterface
{
    /**
     * @param PersisterInterface $backend
     * @param Closure $matcher
     */
    public function addPersister(PersisterInterface $backend, Closure $matcher);

    /**
     * @return \Generator|PersisterInterface[]
     */
    public function walkPersisterList();

    /**
     * @param AttributeInterface $attribute
     * @return PersisterInterface|null
     */
    public function findFor(AttributeInterface $attribute);
}