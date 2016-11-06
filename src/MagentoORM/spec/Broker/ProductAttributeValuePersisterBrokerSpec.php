<?php

namespace spec\Kiboko\Component\MagentoORM\Broker;

use Kiboko\Component\MagentoORM\Matcher\AttributeMatcherInterface;
use Kiboko\Component\MagentoORM\Matcher\AttributeValue\ClosureAttributeValueMatcher;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Persister\AttributeValuePersisterInterface;
use PhpSpec\ObjectBehavior;

class ProductAttributeValuePersisterBrokerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Kiboko\\Component\\MagentoORM\\Broker\\ProductAttributeValuePersisterBroker');
    }

    public function it_should_accept_persisters(
        AttributeValuePersisterInterface $attributeValuePersister,
        AttributeMatcherInterface $attributeValueMatcher
    ) {
        $this->addPersister($attributeValuePersister, $attributeValueMatcher);

        $this->walkPersisterList()
            ->shouldReturnAnInstanceOf('Traversable')
        ;
    }

    public function it_should_find_persisters(
        AttributeValuePersisterInterface $attributeValuePersister,
        AttributeInterface $attribute
    ) {
        $attributeValueMatcher = new ClosureAttributeValueMatcher(function (AttributeInterface $attribute) {
            return true;
        });

        $this->addPersister($attributeValuePersister, $attributeValueMatcher);

        $this->findFor($attribute)
            ->shouldReturnAnInstanceOf(AttributeValuePersisterInterface::class)
        ;
    }

    public function it_may_not_find_persisters(
        AttributeValuePersisterInterface $attributeValuePersister,
        AttributeInterface $attribute
    ) {
        $attributeValueMatcher = new ClosureAttributeValueMatcher(function (AttributeInterface $attribute) {
            return false;
        });

        $this->addPersister($attributeValuePersister, $attributeValueMatcher);

        $this->findFor($attribute)
            ->shouldReturn(null)
        ;
    }
}
