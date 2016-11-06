<?php

namespace spec\Kiboko\Component\MagentoORM\Factory;

use Kiboko\Component\MagentoORM\Factory\StandardProductAttributeValueFactory;
use PhpSpec\ObjectBehavior;

class StandardProductAttributeValueFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(StandardProductAttributeValueFactory::class);
    }
}
