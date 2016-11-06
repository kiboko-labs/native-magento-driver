<?php

namespace spec\Kiboko\Component\MagentoORM\Writer\Database;

use Doctrine\DBAL\Connection;
use League\Flysystem\File;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MySQLDataInfileDatabaseWriterSpec extends ObjectBehavior
{
    function it_is_initializable(File $file, Connection $connection)
    {
        $this->beConstructedWith($connection, $file, ';', '"', '"');
        $this->shouldHaveType('Kiboko\Component\MagentoORM\Writer\Database\MySQLDataInfileDatabaseWriter');
    }
}
