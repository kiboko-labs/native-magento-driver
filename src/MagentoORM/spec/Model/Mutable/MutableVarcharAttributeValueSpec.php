<?php

namespace spec\Kiboko\Component\MagentoORM\Model\Mutable;

use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use PhpSpec\ObjectBehavior;

class MutableVarcharAttributeValueSpec extends ObjectBehavior
{
    public function it_is_an_MutableAttributeValueInterface(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum');
        $this->shouldImplement('Kiboko\Component\MagentoORM\Model\Mutable\MutableAttributeValueInterface');
    }

    public function it_should_contain_string_value(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum');

        $this->getValue()
            ->shouldReturn('Lorem ipsum')
        ;
    }

    public function it_should_be_mutable(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum');

        $this->setValue('Dolor sit amet');

        $this->getValue()
            ->shouldReturn('Dolor sit amet')
        ;
    }
}
