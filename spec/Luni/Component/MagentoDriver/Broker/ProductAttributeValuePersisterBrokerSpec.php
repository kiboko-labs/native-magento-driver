<?php

namespace spec\Luni\Component\MagentoDriver\Broker;

use Luni\Component\MagentoDriver\Matcher\AttributeValueMatcherInterface;
use Luni\Component\MagentoDriver\Matcher\ClosureAttributeValueMatcher;
use Luni\Component\MagentoDriver\Model\Attribute;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Persister\AttributeValuePersisterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductAttributeValuePersisterBrokerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Luni\Component\MagentoDriver\Broker\ProductAttributeValuePersisterBroker');
    }

    function it_should_accept_persisters(
        AttributeValuePersisterInterface $attributeValuePersister,
        AttributeValueMatcherInterface $attributeValueMatcher
    ) {
        $this->addPersister($attributeValuePersister, $attributeValueMatcher);

        $this->walkPersisterList()
            ->shouldReturnAnInstanceOf('Traversable')
        ;
    }

    function it_should_find_persisters(
        AttributeValuePersisterInterface $attributeValuePersister
    ) {
        $attributeValueMatcher = new ClosureAttributeValueMatcher(function(AttributeInterface $attribute) {
            return true;
        });

        $this->addPersister($attributeValuePersister, $attributeValueMatcher);

        $attribute = new Attribute('spec', 'string');

        $this->findFor($attribute)
            ->shouldReturnAnInstanceOf('Luni\Component\MagentoDriver\Persister\AttributeValue\AttributeValuePersisterInterface')
        ;
    }

    function it_may_not_find_persisters(
        AttributeValuePersisterInterface $attributeValuePersister
    ) {
        $attributeValueMatcher = new ClosureAttributeValueMatcher(function(AttributeInterface $attribute) {
            return false;
        });

        $this->addPersister($attributeValuePersister, $attributeValueMatcher);

        $attribute = new Attribute('spec', 'string');

        $this->findFor($attribute)
            ->shouldReturn(null)
        ;
    }
}
