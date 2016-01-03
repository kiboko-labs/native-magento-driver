<?php

namespace spec\Luni\Component\MagentoDriver\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FamilySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('Family label');
        $this->shouldHaveType('Luni\Component\MagentoDriver\Model\Family');
    }
}
