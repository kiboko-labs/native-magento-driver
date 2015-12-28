<?php

namespace spec\Luni\Component\MagentoDriver\AttributeValue\Immutable;

use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImmutableIntegerAttributeValueSpec extends ObjectBehavior
{
    function it_is_an_ImmutableAttributeValueInterface(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 1.5);
        $this->shouldImplement('Luni\Component\MagentoDriver\AttributeValue\Immutable\ImmutableAttributeValueInterface');
    }

    function it_should_contain_integer_value(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 5);

        $this->getValue()
            ->shouldReturn(5)
        ;
    }
}
