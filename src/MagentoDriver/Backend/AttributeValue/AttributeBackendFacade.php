<?php

namespace Luni\Component\MagentoDriver\Backend\AttributeValue;

use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\Broker\AttributeBackendBrokerInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;

class AttributeBackendFacade
    implements BackendInterface
{
    /**
     * @var AttributeBackendBrokerInterface
     */
    private $broker;

    public function __construct(AttributeBackendBrokerInterface $broker)
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
        foreach ($this->broker->walkBackendList() as $backend) {
            $backend->initialize();
        }
    }

    public function flush()
    {
        foreach ($this->broker->walkBackendList() as $backend) {
            $backend->flush();
        }
    }
}