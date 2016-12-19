<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace spec\Kiboko\Component\MagentoORM\Model\V1_9ce\Mutable;

use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use PhpSpec\ObjectBehavior;

class MutableIntegerAttributeValueSpec extends ObjectBehavior
{
    public function it_is_an_MutableAttributeValueInterface(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 1.5);
        $this->shouldImplement('Kiboko\Component\MagentoORM\Model\V1_9ce\MutableAttributeValueInterface');
    }

    public function it_should_contain_integer_value(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 5);

        $this->getValue()
            ->shouldReturn(5)
        ;
    }

    public function it_should_be_mutable(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 5);

        $this->setValue(9);

        $this->getValue()
            ->shouldReturn(9)
        ;
    }
}
