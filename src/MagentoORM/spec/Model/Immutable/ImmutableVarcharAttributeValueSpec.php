<?php

namespace spec\Kiboko\Component\MagentoORM\Model\Immutable;

use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImmutableVarcharAttributeValueSpec extends ObjectBehavior
{
    function it_is_an_ImmutableAttributeValueInterface(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum');
        $this->shouldImplement('Kiboko\Component\MagentoORM\Model\Immutable\ImmutableAttributeValueInterface');
    }

    function it_should_contain_string_value(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum');

        $this->getValue()
            ->shouldReturn('Lorem ipsum')
        ;
    }
}
