<?php

namespace spec\Kiboko\Component\MagentoORM\Filesystem;

use PhpSpec\ObjectBehavior;

class StandardFileMoverSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Kiboko\Component\MagentoORM\Filesystem\StandardFileMover');
    }
}
