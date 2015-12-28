<?php

namespace spec\Luni\Component\MagentoDriver\AttributeValue\Immutable;

use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImmutableDecimalAttributeValueSpec extends ObjectBehavior
{
    function it_is_an_ImmutableAttributeValueInterface(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 1.5);
        $this->shouldImplement('Luni\Component\MagentoDriver\AttributeValue\Immutable\ImmutableAttributeValueInterface');
    }

    function it_should_contain_float_value(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 1.5);

        $this->getValue()
            ->shouldReturn(1.5)
        ;
    }
}
