<?php

namespace spec\Kiboko\Component\MagentoDriver\Filesystem;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StandardFileMoverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kiboko\Component\MagentoDriver\Filesystem\StandardFileMover');
    }
}
