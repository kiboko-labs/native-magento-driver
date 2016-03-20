<?php

namespace spec\Luni\Component\MagentoDriver\Broker;

use Luni\Component\MagentoDriver\Matcher\AttributeValueMatcherInterface;
use Luni\Component\MagentoDriver\Matcher\ClosureAttributeValueMatcher;
use Luni\Component\MagentoDriver\Model\Attribute;
use Luni\Component\MagentoDriver\Model\AttributeInterface;
use Luni\Component\MagentoDriver\Repository\ProductAttributeValueRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductAttributeValueRepositoryBrokerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Luni\Component\MagentoDriver\Broker\ProductAttributeValueRepositoryBroker');
    }

    function it_should_accept_persisters(
        ProductAttributeValueRepositoryInterface $attributeValueRepository,
        AttributeValueMatcherInterface $attributeValueMatcher
    ) {
        $this->addRepository($attributeValueRepository, $attributeValueMatcher);

        $this->walkRepositoryList()
            ->shouldReturnAnInstanceOf('Traversable')
        ;
    }

    function it_should_find_persisters(
        ProductAttributeValueRepositoryInterface $attributeValueRepository
    ) {
        $attributeValueMatcher = new ClosureAttributeValueMatcher(function(AttributeInterface $attribute) {
            return true;
        });

        $this->addRepository($attributeValueRepository, $attributeValueMatcher);

        $attribute = new Attribute('spec', 'string');

        $this->findFor($attribute)
            ->shouldReturnAnInstanceOf('Luni\Component\MagentoDriver\Repository\ProductAttributeValueRepositoryInterface')
        ;
    }

    function it_may_not_find_persisters(
        ProductAttributeValueRepositoryInterface $attributeValueRepository
    ) {
        $attributeValueMatcher = new ClosureAttributeValueMatcher(function(AttributeInterface $attribute) {
            return false;
        });

        $this->addRepository($attributeValueRepository, $attributeValueMatcher);

        $attribute = new Attribute('spec', 'string');

        $this->findFor($attribute)
            ->shouldReturn(null)
        ;
    }
}
