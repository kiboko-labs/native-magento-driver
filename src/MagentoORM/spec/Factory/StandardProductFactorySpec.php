<?php

namespace spec\Kiboko\Component\MagentoORM\Factory;

use Kiboko\Component\MagentoORM\Broker\ProductFactoryBrokerInterface;
use Kiboko\Component\MagentoORM\Factory\StandardProductFactory;
use PhpSpec\ObjectBehavior;

class StandardProductFactorySpec extends ObjectBehavior
{
    public function it_is_initializable(
        ProductFactoryBrokerInterface $broker
    ) {
        $this->beConstructedWith($broker);
        $this->shouldHaveType(StandardProductFactory::class);
    }
}
