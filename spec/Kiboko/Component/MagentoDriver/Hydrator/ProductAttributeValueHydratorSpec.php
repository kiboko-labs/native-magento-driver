<?php

namespace spec\Kiboko\Component\MagentoDriver\Hydrator;

use Kiboko\Component\MagentoDriver\Repository\ProductAttributeRepositoryInterface;
use Kiboko\Component\MagentoDriver\Repository\ProductAttributeValueRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductAttributeValueHydratorSpec extends ObjectBehavior
{
    function it_is_initializable(
        ProductAttributeValueRepositoryInterface $attributeValueRepository,
        ProductAttributeRepositoryInterface $attributeRepository
    ) {
        $this->beConstructedWith($attributeValueRepository, $attributeRepository);
        $this->shouldHaveType('Kiboko\Component\MagentoDriver\Hydrator\ProductAttributeValueHydrator');
    }
}
