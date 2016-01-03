<?php

namespace Luni\Component\MagentoDriver\Broker;

use Closure;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Persister\AttributeValue\AttributeValuePersisterInterface;

interface ProductAttributeValuePersisterBrokerInterface
{
    /**
     * @param AttributeValuePersisterInterface $backend
     * @param Closure $matcher
     */
    public function addPersister(AttributeValuePersisterInterface $backend, Closure $matcher);

    /**
     * @return \Generator|AttributeValuePersisterInterface[]
     */
    public function walkPersisterList();

    /**
     * @param AttributeInterface $attribute
     * @return AttributeValuePersisterInterface|null
     */
    public function findFor(AttributeInterface $attribute);
}