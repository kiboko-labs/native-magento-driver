<?php

namespace spec\Luni\Component\MagentoDriver\Attribute;

use Luni\Component\MagentoDriver\AttributeBackend\BackendInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AttributeSpec extends ObjectBehavior
{
    function it_is_initializable(BackendInterface $backend)
    {
        $this->beConstructedWith('lorem_ipsum', $backend, []);

        $this->shouldHaveType('Luni\Component\MagentoDriver\Attribute\Attribute');
    }
}
