<?php

namespace spec\Kiboko\Component\MagentoDriver\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CategorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kiboko\Component\MagentoDriver\Entity\Category');
    }
}
