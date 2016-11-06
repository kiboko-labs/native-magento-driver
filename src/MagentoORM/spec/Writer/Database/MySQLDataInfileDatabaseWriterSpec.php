<?php

namespace spec\Kiboko\Component\MagentoORM\Writer\Database;

use Doctrine\DBAL\Connection;
use League\Flysystem\File;
use PhpSpec\ObjectBehavior;

class MySQLDataInfileDatabaseWriterSpec extends ObjectBehavior
{
    public function it_is_initializable(File $file, Connection $connection)
    {
        $this->beConstructedWith($connection, $file, ';', '"', '"');
        $this->shouldHaveType('Kiboko\Component\MagentoORM\Writer\Database\MySQLDataInfileDatabaseWriter');
    }
}
