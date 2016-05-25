<?php

namespace spec\Kiboko\Component\MagentoDriver\Model\Immutable;

use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImmutableImageMetadataAttributeValueSpec extends ObjectBehavior
{
    function it_is_an_ImmutableAttributeValueInterface(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', 1, false, 0);
        $this->shouldImplement('Kiboko\Component\MagentoDriver\Model\Immutable\ImmutableAttributeValueInterface');
    }

    function it_should_contain_label_value_as_string(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', 1, false, 0);

        $this->getLabel()
            ->shouldReturn('Lorem ipsum')
        ;
    }

    function it_should_contain_position_value_as_int(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', 1, false, 0);

        $this->getPosition()
            ->shouldReturn(1)
        ;
    }

    function it_should_contain_position_value_as_int_if_set_as_string(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', '43', false, 0);

        $this->getPosition()
            ->shouldReturn(43)
        ;
    }

    function it_should_contain_exclusion_value_as_boolean(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', 1, false, 0);

        $this->isExcluded()
            ->shouldReturn(false)
        ;
    }

    function it_should_contain_exclusion_value_as_boolean_if_set_as_random_string(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', 1, 'random string', 0);

        $this->isExcluded()
            ->shouldReturn(true)
        ;
    }

    function it_should_contain_exclusion_value_as_boolean_if_set_as_integer(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', 1, 56, 0);

        $this->isExcluded()
            ->shouldReturn(true)
        ;
    }

    function it_should_contain_exclusion_value_as_boolean_if_set_as_zero(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', 1, 0, 0);

        $this->isExcluded()
            ->shouldReturn(false)
        ;
    }

    function it_should_contain_storeId_value_as_int(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', 1, false, 1);

        $this->getStoreId()
            ->shouldReturn(1)
        ;
    }

    function it_should_contain_storeId_value_as_int_if_set_as_string(AttributeInterface $attribute)
    {
        $this->beConstructedWith($attribute, 'Lorem ipsum', 1, false, '43');

        $this->getStoreId()
            ->shouldReturn(43)
        ;
    }
}
