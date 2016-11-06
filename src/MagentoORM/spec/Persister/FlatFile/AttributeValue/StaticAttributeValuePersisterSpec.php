<?php

namespace spec\Kiboko\Component\MagentoORM\Persister\FlatFile\AttributeValue;

use PhpSpec\ObjectBehavior;

class StaticAttributeValuePersisterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Kiboko\Component\MagentoORM\Persister\FlatFile\AttributeValue\StaticAttributeValuePersister');
    }
}
