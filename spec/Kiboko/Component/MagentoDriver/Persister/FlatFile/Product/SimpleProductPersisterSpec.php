<?php

namespace spec\Kiboko\Component\MagentoDriver\Persister\FlatFile\Product;

use Kiboko\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Kiboko\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SimpleProductPersisterSpec extends ObjectBehavior
{
    function it_is_initializable(
        TemporaryWriterInterface $temporaryWriter,
        DatabaseWriterInterface $databaseWriter
    ) {
        $this->beConstructedWith($temporaryWriter, $databaseWriter, 'table', []);
        $this->shouldHaveType('Kiboko\Component\MagentoDriver\Persister\FlatFile\Product\SimpleProductPersister');
    }
}
