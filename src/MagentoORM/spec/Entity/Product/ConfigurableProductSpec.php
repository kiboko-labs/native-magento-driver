<?php

namespace spec\Kiboko\Component\MagentoORM\Entity\Product;

use Kiboko\Component\MagentoORM\Model\FamilyInterface;
use PhpSpec\ObjectBehavior;

class ConfigurableProductSpec extends ObjectBehavior
{
    public function it_is_initializable(
        FamilyInterface $family
    ) {
        $this->beConstructedWith(1337, $family);
        $this->shouldHaveType('Kiboko\Component\MagentoORM\Entity\Product\ConfigurableProduct');
    }
}
