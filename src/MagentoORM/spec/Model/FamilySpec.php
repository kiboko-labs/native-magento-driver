<?php

namespace spec\Kiboko\Component\MagentoORM\Model;

use Kiboko\Component\MagentoORM\Model\Family;
use PhpSpec\ObjectBehavior;

class FamilySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('Family label');
        $this->shouldHaveType(Family::class);
    }
}
