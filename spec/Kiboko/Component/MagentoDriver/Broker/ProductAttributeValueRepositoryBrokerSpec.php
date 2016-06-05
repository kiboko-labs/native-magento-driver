<?php

namespace spec\Kiboko\Component\MagentoDriver\Broker;

use Kiboko\Component\MagentoDriver\Broker\ProductAttributeValueRepositoryBroker;
use Kiboko\Component\MagentoDriver\Matcher\AttributeMatcherInterface;
use Kiboko\Component\MagentoDriver\Matcher\AttributeValue\ClosureAttributeValueMatcher;
use Kiboko\Component\MagentoDriver\Model\Attribute;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use Kiboko\Component\MagentoDriver\Repository\ProductAttributeValueRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductAttributeValueRepositoryBrokerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ProductAttributeValueRepositoryBroker::class);
    }

    function it_should_accept_persisters(
        ProductAttributeValueRepositoryInterface $attributeValueRepository,
        AttributeMatcherInterface $attributeValueMatcher
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
            ->shouldReturnAnInstanceOf(ProductAttributeValueRepositoryInterface::class)
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
