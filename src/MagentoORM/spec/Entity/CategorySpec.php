<?php

namespace spec\Kiboko\Component\MagentoORM\Entity;

use PhpSpec\ObjectBehavior;

class CategorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Kiboko\Component\MagentoORM\Entity\Category');
    }
}
