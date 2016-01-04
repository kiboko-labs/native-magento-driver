<?php

namespace Luni\Component\MagentoDriver\Persister\AttributeValue;

use Luni\Component\MagentoDriver\Model\AttributeValueInterface;
use Luni\Component\MagentoDriver\Broker\ProductAttributeValuePersisterBrokerInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;

class AttributeValuePersisterFacade
    implements AttributeValuePersisterInterface
{
    /**
     * @var ProductAttributeValuePersisterBrokerInterface
     */
    private $broker;

    public function __construct(ProductAttributeValuePersisterBrokerInterface $broker)
    {
        $this->broker = $broker;
    }

    /**
     *
     */
    public function initialize()
    {
        foreach ($this->broker->walkPersisterList() as $backend) {
            $backend->initialize();
        }
    }

    /**
     * @param AttributeValueInterface $value
     */
    public function persist(AttributeValueInterface $value)
    {
        $backend = $this->broker->findFor($value->getAttribute());

        if ($backend === null) {
            return;
        }

        $backend->persist($value);
    }

    /**
     *
     */
    public function flush()
    {
        foreach ($this->broker->walkPersisterList() as $backend) {
            $backend->flush();
        }
    }
}