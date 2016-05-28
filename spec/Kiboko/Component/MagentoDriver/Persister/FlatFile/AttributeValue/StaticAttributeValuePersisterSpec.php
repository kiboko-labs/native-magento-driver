<?php

namespace spec\Kiboko\Component\MagentoDriver\Persister\FlatFile\AttributeValue;

use Kiboko\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Kiboko\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StaticAttributeValuePersisterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kiboko\Component\MagentoDriver\Persister\FlatFile\AttributeValue\StaticAttributeValuePersister');
    }
}
