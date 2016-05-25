<?php

namespace spec\Kiboko\Component\MagentoDriver\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StandardProductFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kiboko\Component\MagentoDriver\Factory\StandardProductFactory');
    }
}
