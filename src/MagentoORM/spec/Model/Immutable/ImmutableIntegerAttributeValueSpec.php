<?php

namespace spec\Kiboko\Component\MagentoORM\Model\Immutable;

use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use PhpSpec\ObjectBehavior;

class ImmutableIntegerAttributeValueSpec extends ObjectBehavior
{
    public function it_is_an_ImmutableAttributeValueInterface(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 1.5);
        $this->shouldImplement('Kiboko\Component\MagentoORM\Model\Immutable\ImmutableAttributeValueInterface');
    }

    public function it_should_contain_integer_value(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 5);

        $this->getValue()
            ->shouldReturn(5)
        ;
    }
}
