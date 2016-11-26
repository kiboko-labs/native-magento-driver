<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace spec\Kiboko\Component\MagentoORM\Model\Magento19\Mutable;

use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use PhpSpec\ObjectBehavior;

class MutableImageMetadataAttributeValueSpec extends ObjectBehavior
{
    public function it_is_an_ImmutableAttributeValueInterface(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', 1, false, 0);
        $this->shouldImplement('Kiboko\Component\MagentoORM\Model\Magento19\MutableAttributeValueInterface');
    }

    public function it_should_contain_label_value_as_string(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', 1, false, 0);

        $this->getLabel()
            ->shouldReturn('Lorem ipsum')
        ;
    }

    public function it_should_contain_position_value_as_int(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', 1, false, 0);

        $this->getPosition()
            ->shouldReturn(1)
        ;
    }

    public function it_should_contain_position_value_as_int_if_set_as_string(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', '43', false, 0);

        $this->getPosition()
            ->shouldReturn(43)
        ;
    }

    public function it_should_contain_exclusion_value_as_boolean(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', 1, false, 0);

        $this->isExcluded()
            ->shouldReturn(false)
        ;
    }

    public function it_should_contain_exclusion_value_as_boolean_if_set_as_random_string(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', 1, 'random string', 0);

        $this->isExcluded()
            ->shouldReturn(true)
        ;
    }

    public function it_should_contain_exclusion_value_as_boolean_if_set_as_integer(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', 1, 56, 0);

        $this->isExcluded()
            ->shouldReturn(true)
        ;
    }

    public function it_should_contain_exclusion_value_as_boolean_if_set_as_zero(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', 1, 0, 0);

        $this->isExcluded()
            ->shouldReturn(false)
        ;
    }

    public function it_should_contain_storeId_value_as_int(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', 1, false, 1);

        $this->getStoreId()
            ->shouldReturn(1)
        ;
    }

    public function it_should_contain_storeId_value_as_int_if_set_as_string(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', 1, false, '43');

        $this->getStoreId()
            ->shouldReturn(43)
        ;
    }

    public function it_should_be_mutable(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', 1, false, 0);

        $this->setLabel('Dolor sit amet');
        $this->setPosition(43);
        $this->setExcluded(true);

        $this->getLabel()
            ->shouldReturn('Dolor sit amet')
        ;

        $this->getposition()
            ->shouldReturn(43)
        ;

        $this->isExcluded()
            ->shouldReturn(true)
        ;
    }
}
