<?php

namespace spec\Luni\Component\MagentoDriver\ModelValue\Mutable;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MutableTextAttributeValueSpec extends ObjectBehavior
{
    function it_is_an_MutableAttributeValueInterface(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum');
        $this->shouldImplement('Luni\Component\MagentoDriver\ModelValue\Mutable\MutableAttributeValueInterface');
    }

    function it_should_contain_string_value(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum');

        $this->getValue()
            ->shouldReturn('Lorem ipsum')
        ;
    }

    function it_should_be_mutable(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum');

        $this->setValue('Dolor sit amet');

        $this->getValue()
            ->shouldReturn('Dolor sit amet')
        ;
    }
}
