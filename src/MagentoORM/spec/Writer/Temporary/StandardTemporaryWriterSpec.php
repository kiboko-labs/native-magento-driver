<?php

namespace spec\Kiboko\Component\MagentoORM\Writer\Temporary;

use League\Flysystem\File;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StandardTemporaryWriterSpec extends ObjectBehavior
{
    function it_is_initializable(File $file)
    {
        $this->beConstructedWith($file, ';', '"', '"');
        $this->shouldHaveType('Kiboko\Component\MagentoORM\Writer\Temporary\StandardTemporaryWriter');
    }

    function it_writes_to_file(File $file)
    {
        $this->beConstructedWith($file, ';', '"', '"');

        $this->persistRow(['test', 123, true]);

        $file->putStream(Argument::type('resource'))->shouldBeCalled();

        $this->flush();
    }
}
