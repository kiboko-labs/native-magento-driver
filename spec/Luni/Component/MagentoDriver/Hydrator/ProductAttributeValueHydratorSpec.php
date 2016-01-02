<?php

namespace spec\Luni\Component\MagentoDriver\Hydrator;

use Luni\Component\MagentoDriver\Repository\ProductAttributeRepositoryInterface;
use Luni\Component\MagentoDriver\Repository\ProductAttributeValueRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ProductAttributeValueHydratorSpec extends ObjectBehavior
{
    function it_is_initializable(
        ProductAttributeValueRepositoryInterface $attributeValueRepository,
        ProductAttributeRepositoryInterface $attributeRepository
    ) {
        $this->beConstructedWith($attributeValueRepository, $attributeRepository);
        $this->shouldHaveType('Luni\Component\MagentoDriver\Hydrator\ProductAttributeValueHydrator');
    }
}
