<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Broker;

use Kiboko\Component\MagentoORM\Matcher\AttributeMatcherInterface;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Persister\AttributeValuePersisterInterface;

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
