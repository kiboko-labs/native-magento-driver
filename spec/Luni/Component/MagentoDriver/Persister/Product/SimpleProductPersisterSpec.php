<?php

namespace spec\Luni\Component\MagentoDriver\Persister\Product;

use Luni\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Luni\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SimpleProductPersisterSpec extends ObjectBehavior
{
    function it_is_initializable(
        TemporaryWriterInterface $temporaryWriter,
        DatabaseWriterInterface $databaseWriter
    ) {
        $this->beConstructedWith($temporaryWriter, $databaseWriter, 'table', []);
        $this->shouldHaveType('Luni\Component\MagentoDriver\Persister\Product\SimpleProductPersister');
    }
}
