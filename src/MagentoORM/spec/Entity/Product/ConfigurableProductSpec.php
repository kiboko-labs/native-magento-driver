<?php

namespace spec\Kiboko\Component\MagentoORM\Entity\Product;

use Kiboko\Component\MagentoORM\Model\FamilyInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigurableProductSpec extends ObjectBehavior
{
    function it_is_initializable(
        FamilyInterface $family
    ) {
        $this->beConstructedWith(1337, $family);
        $this->shouldHaveType('Kiboko\Component\MagentoORM\Entity\Product\ConfigurableProduct');
    }
}
