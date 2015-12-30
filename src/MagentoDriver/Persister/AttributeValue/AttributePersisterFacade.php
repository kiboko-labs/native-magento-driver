<?php

namespace Luni\Component\MagentoDriver\Persister\AttributeValue;

use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\Broker\AttributePersisterBrokerInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;

class AttributePersisterFacade
    implements PersisterInterface
{
    /**
     * @var AttributePersisterBrokerInterface
     */
    private $broker;

    public function __construct(AttributePersisterBrokerInterface $broker)
    {
        $this->broker = $broker;
    }

    public function persist(ProductInterface $product, AttributeValueInterface $value)
    {
        $backend = $this->broker->findFor($value->getAttribute());
        if ($backend === null) {
            return;
        }

        $backend->persist($product, $value);
    }

    public function initialize()
    {
        foreach ($this->broker->walkPersisterList() as $backend) {
            $backend->initialize();
        }
    }

    public function flush()
    {
        foreach ($this->broker->walkPersisterList() as $backend) {
            $backend->flush();
        }
    }
}