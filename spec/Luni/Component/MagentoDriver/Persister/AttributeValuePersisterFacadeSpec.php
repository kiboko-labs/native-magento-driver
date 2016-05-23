<?php

namespace spec\Kiboko\Component\MagentoDriver\Persister;

use Kiboko\Component\MagentoDriver\Broker\ProductAttributeValuePersisterBrokerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AttributeValuePersisterFacadeSpec extends ObjectBehavior
{
    function it_is_initializable(ProductAttributeValuePersisterBrokerInterface $broker)
    {
        $this->beConstructedWith($broker);
        $this->shouldHaveType('Kiboko\Component\MagentoDriver\Persister\AttributeValuePersisterFacade');
    }
}
