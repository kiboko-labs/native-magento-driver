<?php

namespace spec\Kiboko\Component\MagentoORM\Writer\Database;

use Doctrine\DBAL\Connection;
use League\Flysystem\File;
use League\Flysystem\Filesystem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MySQLLocalDataInfileDatabaseWriterSpec extends ObjectBehavior
{
    function it_is_initializable(Connection $connection, Filesystem $filesystem, File $file)
    {
        $this->beConstructedWith($connection, $filesystem, $file, ';', '"', '"');
        $this->shouldHaveType('Kiboko\Component\MagentoORM\Writer\Database\MySQLLocalDataInfileDatabaseWriter');
    }
}
