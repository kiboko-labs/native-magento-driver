<?php

namespace spec\Luni\Component\MagentoDriver\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CategorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Luni\Component\MagentoDriver\Entity\Category');
    }
}
