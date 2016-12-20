<?php

namespace spec\Kiboko\Component\Connector;

use Kiboko\Component\Connector\PriorityChain;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PriorityChainSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PriorityChain::class);
    }

    function it_is_countable()
    {
        $this->shouldImplementInterface(\Countable::class);
    }

    function it_is_traversable()
    {
        $this->shouldImplementInterface(\Traversable::class);
    }
}
