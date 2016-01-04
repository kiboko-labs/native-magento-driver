<?php

namespace Luni\Component\MagentoDriver\Broker;

use Luni\Component\MagentoDriver\Matcher\AttributeValuePersisterMatcherInterface;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Persister\AttributeValue\AttributeValuePersisterInterface;

interface ProductAttributeValuePersisterBrokerInterface
{
    /**
     * @param AttributeValuePersisterInterface $backend
     * @param AttributeValuePersisterMatcherInterface $matcher
     */
    public function addPersister(AttributeValuePersisterInterface $backend, AttributeValuePersisterMatcherInterface $matcher);

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