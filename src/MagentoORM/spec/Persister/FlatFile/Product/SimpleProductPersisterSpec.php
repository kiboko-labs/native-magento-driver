<?php

namespace spec\Kiboko\Component\MagentoORM\Persister\FlatFile\Product;

use Kiboko\Component\MagentoORM\Writer\Database\DatabaseWriterInterface;
use Kiboko\Component\MagentoORM\Writer\Temporary\TemporaryWriterInterface;
use PhpSpec\ObjectBehavior;

class SimpleProductPersisterSpec extends ObjectBehavior
{
    public function it_is_initializable(
        TemporaryWriterInterface $temporaryWriter,
        DatabaseWriterInterface $databaseWriter
    ) {
        $this->beConstructedWith($temporaryWriter, $databaseWriter, 'table', []);
        $this->shouldHaveType('Kiboko\Component\MagentoORM\Persister\FlatFile\Product\SimpleProductPersister');
    }
}
