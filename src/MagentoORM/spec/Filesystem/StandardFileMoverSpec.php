<?php

namespace spec\Kiboko\Component\MagentoORM\Filesystem;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StandardFileMoverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kiboko\Component\MagentoORM\Filesystem\StandardFileMover');
    }
}
