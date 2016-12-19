<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace spec\Kiboko\Component\MagentoORM\Model\V2_0ce\Mutable;

use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use PhpSpec\ObjectBehavior;

class MutableDecimalAttributeValueSpec extends ObjectBehavior
{
    public function it_is_an_MutableAttributeValueInterface(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 1.5);
        $this->shouldImplement('Kiboko\Component\MagentoORM\Model\V2_0ce\MutableAttributeValueInterface');
    }

    public function it_should_contain_float_value(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 1.5);

        $this->getValue()
            ->shouldReturn(1.5)
        ;
    }

    public function it_should_be_mutable(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 1.5);

        $this->setValue(7.5);

        $this->getValue()
            ->shouldReturn(7.5)
        ;
    }
}
