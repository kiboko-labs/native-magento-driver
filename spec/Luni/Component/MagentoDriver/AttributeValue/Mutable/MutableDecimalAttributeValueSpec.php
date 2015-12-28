<?php

namespace spec\Luni\Component\MagentoDriver\AttributeValue\Mutable;

use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MutableDecimalAttributeValueSpec extends ObjectBehavior
{
    function it_is_an_MutableAttributeValueInterface(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 1.5);
        $this->shouldImplement('Luni\Component\MagentoDriver\AttributeValue\Mutable\MutableAttributeValueInterface');
    }

    function it_should_contain_float_value(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 1.5);

        $this->getValue()
            ->shouldReturn(1.5)
        ;
    }

    function it_should_be_mutable(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 1.5);

        $this->setValue(7.5);

        $this->getValue()
            ->shouldReturn(7.5)
        ;
    }
}
