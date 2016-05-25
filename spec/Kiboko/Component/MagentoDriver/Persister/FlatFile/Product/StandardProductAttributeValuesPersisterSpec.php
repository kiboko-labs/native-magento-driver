<?php

namespace spec\Kiboko\Component\MagentoDriver\Persister\FlatFile\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Kiboko\Component\MagentoDriver\Persister\AttributeValuePersisterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StandardProductAttributeValuesPersisterSpec extends ObjectBehavior
{
    function it_is_initializable(
        AttributeValuePersisterInterface $persister,
        Collection $collection
    ) {
        $this->beConstructedWith($persister, $collection);
        $this->shouldHaveType('Kiboko\Component\MagentoDriver\Persister\FlatFile\Product\StandardProductAttributeValuesPersister');
    }
}
