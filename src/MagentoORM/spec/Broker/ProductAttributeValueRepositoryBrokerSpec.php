<?php

namespace spec\Kiboko\Component\MagentoORM\Broker;

use Kiboko\Component\MagentoORM\Matcher\AttributeMatcherInterface;
use Kiboko\Component\MagentoORM\Matcher\AttributeValue\ClosureAttributeValueMatcher;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use Kiboko\Component\MagentoORM\Repository\ProductAttributeValueRepositoryInterface;
use PhpSpec\ObjectBehavior;

class ProductAttributeValueRepositoryBrokerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kiboko\\Component\\MagentoORM\\Broker\\ProductAttributeValueRepositoryBroker');
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
        ProductAttributeValueRepositoryInterface $attributeValueRepository,
        AttributeInterface $attribute
    ) {
        $attributeValueMatcher = new ClosureAttributeValueMatcher(function(AttributeInterface $attribute) {
            return true;
        });

        $this->addRepository($attributeValueRepository, $attributeValueMatcher);

        $this->findFor($attribute)
            ->shouldReturnAnInstanceOf(ProductAttributeValueRepositoryInterface::class)
        ;
    }

    function it_may_not_find_persisters(
        ProductAttributeValueRepositoryInterface $attributeValueRepository,
        AttributeInterface $attribute
    ) {
        $attributeValueMatcher = new ClosureAttributeValueMatcher(function(AttributeInterface $attribute) {
            return false;
        });

        $this->addRepository($attributeValueRepository, $attributeValueMatcher);

        $this->findFor($attribute)
            ->shouldReturn(null)
        ;
    }
}
