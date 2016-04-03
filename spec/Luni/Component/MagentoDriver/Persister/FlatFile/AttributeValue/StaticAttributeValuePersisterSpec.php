<?php

namespace spec\Luni\Component\MagentoDriver\Persister\FlatFile\AttributeValue;

use Luni\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Luni\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StaticAttributeValuePersisterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Luni\Component\MagentoDriver\Persister\FlatFile\AttributeValue\StaticAttributeValuePersister');
    }
}
