<?php

namespace spec\Kiboko\Component\MagentoORM\Model;

use Kiboko\Component\MagentoORM\Model\Attribute;
use PhpSpec\ObjectBehavior;

class AttributeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(3, 'test', null, null, null, null, null, null, null, null, null, null, null, null, null);
        $this->shouldHaveType(Attribute::class);
    }
}
