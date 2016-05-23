<?php

namespace spec\Kiboko\Component\MagentoDriver\Entity\Product;

use Kiboko\Component\MagentoDriver\Model\FamilyInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SimpleProductSpec extends ObjectBehavior
{
    function it_is_initializable(
        FamilyInterface $family
    ) {
        $this->beConstructedWith(1337, $family);
        $this->shouldHaveType('Kiboko\Component\MagentoDriver\Entity\Product\SimpleProduct');
    }
}
