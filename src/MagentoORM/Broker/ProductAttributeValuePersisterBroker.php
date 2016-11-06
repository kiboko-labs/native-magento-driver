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

class ProductAttributeValuePersisterBroker implements ProductAttributeValuePersisterBrokerInterface
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
     * @param AttributeMatcherInterface        $matcher
     */
    public function addPersister(
        AttributeValuePersisterInterface $backend,
        AttributeMatcherInterface $matcher
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
     *
     * @return AttributeValuePersisterInterface|null
     */
    public function findFor(AttributeInterface $attribute)
    {
        /**
         * @var AttributeMatcherInterface $matcher
         * @var AttributeValuePersisterInterface $backend
         */
        foreach ($this->walkPersisterList() as $matcher => $backend) {
            if ($matcher->match($attribute) !== true) {
                continue;
            }

            return $backend;
        }

        return;
    }
}
