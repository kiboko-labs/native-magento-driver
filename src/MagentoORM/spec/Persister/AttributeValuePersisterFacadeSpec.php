<?php

namespace spec\Kiboko\Component\MagentoORM\Persister;

use Kiboko\Component\MagentoORM\Broker\ProductAttributeValuePersisterBrokerInterface;
use PhpSpec\ObjectBehavior;

class AttributeValuePersisterFacadeSpec extends ObjectBehavior
{
    public function it_is_initializable(ProductAttributeValuePersisterBrokerInterface $broker)
    {
        $this->beConstructedWith($broker);
        $this->shouldHaveType('Kiboko\Component\MagentoORM\Persister\AttributeValuePersisterFacade');
    }
}
