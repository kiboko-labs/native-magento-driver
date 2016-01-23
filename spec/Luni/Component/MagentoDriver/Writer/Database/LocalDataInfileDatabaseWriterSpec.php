<?php

namespace spec\Luni\Component\MagentoDriver\Writer\Database;

use Doctrine\DBAL\Connection;
use League\Flysystem\File;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LocalDataInfileDatabaseWriterSpec extends ObjectBehavior
{
    function it_is_initializable(File $file, Connection $connection)
    {
        $this->beConstructedWith($connection, $file, ';', '"', '"');
        $this->shouldHaveType('Luni\Component\MagentoDriver\Writer\Database\LocalDataInfileDatabaseWriter');
    }
}
