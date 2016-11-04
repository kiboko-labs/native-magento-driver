<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoDriver\Broker;

use Kiboko\Component\MagentoDriver\Matcher\AttributeMatcherInterface;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Persister\AttributeValuePersisterInterface;

interface ProductAttributeValuePersisterBrokerInterface
{
    /**
     * @param AttributeValuePersisterInterface $backend
     * @param AttributeMatcherInterface   $matcher
     */
    public function addPersister(AttributeValuePersisterInterface $backend, AttributeMatcherInterface $matcher);

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
