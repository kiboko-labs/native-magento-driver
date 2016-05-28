<?php

namespace Kiboko\Component\MagentoDriver\Broker;

use Kiboko\Component\MagentoDriver\Matcher\AttributeValueMatcherInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Persister\AttributeValuePersisterInterface;

interface ProductAttributeValuePersisterBrokerInterface
{
    /**
     * @param AttributeValuePersisterInterface $backend
     * @param AttributeValueMatcherInterface   $matcher
     */
    public function addPersister(AttributeValuePersisterInterface $backend, AttributeValueMatcherInterface $matcher);

    /**
     * @return \Generator|AttributeValuePersisterInterface[]
     */
    public function walkPersisterList();

    /**
     * @param AttributeInterface $attribute
     *
     * @return AttributeValuePersisterInterface|null
     */
    public function findFor(AttributeInterface $attribute);
}
