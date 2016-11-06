<?php

namespace spec\Kiboko\Component\MagentoORM\Hydrator;

use Kiboko\Component\MagentoORM\Repository\ProductAttributeRepositoryInterface;
use Kiboko\Component\MagentoORM\Repository\ProductAttributeValueRepositoryInterface;
use PhpSpec\ObjectBehavior;

class ProductAttributeValueHydratorSpec extends ObjectBehavior
{
    public function it_is_initializable(
        ProductAttributeValueRepositoryInterface $attributeValueRepository,
        ProductAttributeRepositoryInterface $attributeRepository
    ) {
        $this->beConstructedWith($attributeValueRepository, $attributeRepository);
        $this->shouldHaveType('Kiboko\Component\MagentoORM\Hydrator\ProductAttributeValueHydrator');
    }
}
