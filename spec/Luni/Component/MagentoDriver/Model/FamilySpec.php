<?php

namespace spec\Kiboko\Component\MagentoDriver\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FamilySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('Family label');
        $this->shouldHaveType('Kiboko\Component\MagentoDriver\Model\Family');
    }
}
