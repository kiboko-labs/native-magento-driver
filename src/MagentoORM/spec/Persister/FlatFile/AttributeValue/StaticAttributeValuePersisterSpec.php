<?php

namespace spec\Kiboko\Component\MagentoORM\Persister\FlatFile\AttributeValue;

use Kiboko\Component\MagentoORM\Writer\Database\DatabaseWriterInterface;
use Kiboko\Component\MagentoORM\Writer\Temporary\TemporaryWriterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StaticAttributeValuePersisterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Kiboko\Component\MagentoORM\Persister\FlatFile\AttributeValue\StaticAttributeValuePersister');
    }
}
