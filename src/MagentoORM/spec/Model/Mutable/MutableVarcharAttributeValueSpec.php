<?php

namespace spec\Kiboko\Component\MagentoORM\Model\Mutable;

use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MutableVarcharAttributeValueSpec extends ObjectBehavior
{
    function it_is_an_MutableAttributeValueInterface(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum');
        $this->shouldImplement('Kiboko\Component\MagentoORM\Model\Mutable\MutableAttributeValueInterface');
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
