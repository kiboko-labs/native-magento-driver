<?php

namespace spec\Luni\Component\MagentoDriver\Persister\Product;

use Luni\Component\MagentoDriver\Persister\AttributeValue\AttributeValuePersisterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StandardProductAttributeValuesPersisterSpec extends ObjectBehavior
{
    function it_is_initializable(
        AttributeValuePersisterInterface $persister
    ) {
        $this->beConstructedWith($persister, []);
        $this->shouldHaveType('Luni\Component\MagentoDriver\Persister\Product\StandardProductAttributeValuesPersister');
    }
}
