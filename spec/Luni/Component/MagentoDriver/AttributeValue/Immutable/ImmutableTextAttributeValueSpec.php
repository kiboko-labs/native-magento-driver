<?php

namespace spec\Luni\Component\MagentoDriver\AttributeValue\Immutable;

use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImmutableTextAttributeValueSpec extends ObjectBehavior
{
    function it_is_an_ImmutableAttributeValueInterface(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum');
        $this->shouldImplement('Luni\Component\MagentoDriver\AttributeValue\Immutable\ImmutableAttributeValueInterface');
    }

    function it_should_contain_string_value(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum');

        $this->getValue()
            ->shouldReturn('Lorem ipsum')
        ;
    }
}
