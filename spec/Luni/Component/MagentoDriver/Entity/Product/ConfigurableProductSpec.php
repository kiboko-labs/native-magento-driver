<?php

namespace spec\Luni\Component\MagentoDriver\Entity\Product;

use Luni\Component\MagentoDriver\Model\FamilyInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigurableProductSpec extends ObjectBehavior
{
    function it_is_initializable(
        FamilyInterface $family
    ) {
        $this->beConstructedWith(1337, $family);
        $this->shouldHaveType('Luni\Component\MagentoDriver\Entity\Product\ConfigurableProduct');
    }
}
