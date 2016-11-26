<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace spec\Kiboko\Component\MagentoORM\Model\Magento19\Immutable;

use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use PhpSpec\ObjectBehavior;

class ImmutableDecimalAttributeValueSpec extends ObjectBehavior
{
    public function it_is_an_ImmutableAttributeValueInterface(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 1.5);
        $this->shouldImplement('Kiboko\Component\MagentoORM\Model\Magento19\ImmutableAttributeValueInterface');
    }

    public function it_should_contain_float_value(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 1.5);

        $this->getValue()
            ->shouldReturn(1.5)
        ;
    }
}
