<?php

namespace spec\Kiboko\Component\MagentoDriver\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AttributeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('lorem_ipsum', []);

        $this->shouldHaveType('Kiboko\Component\MagentoDriver\Model\Attribute');
    }
}
