<?php

namespace spec\Luni\Component\MagentoDriver\ModelValue\Mutable;

use Luni\Component\MagentoDriver\Model\AttributeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MutableDatetimeAttributeValueSpec extends ObjectBehavior
{
    public function getMatchers()
    {
        return [
            'beTimestamp' => function(\DateTimeInterface $subject, $timestamp) {
                return $subject->getTimestamp() === $timestamp;
            },
        ];
    }

    function it_is_an_MutableAttributeValueInterface(AttributeInterface $attribute, \DateTimeImmutable $datetime)
    {
        $this->beConstructedWith($attribute, $datetime);
        $this->shouldImplement('Luni\Component\MagentoDriver\ModelValue\Mutable\MutableAttributeValueInterface');
    }

    function it_should_contain_immutable_datetime_value(AttributeInterface $attribute, \DateTimeImmutable $datetime)
    {
        $this->beConstructedWith($attribute, $datetime);

        $datetime->getTimestamp()->willReturn(1234567890);

        $this->getValue()
            ->shouldReturnAnInstanceOf('DateTimeImmutable')
        ;

        $this->getValue()
            ->shouldBeTimestamp(1234567890)
        ;
    }

    function it_should_be_mutable(AttributeInterface $attribute, \DateTimeImmutable $datetime)
    {
        $this->beConstructedWith($attribute, $datetime);

        $datetime->getTimestamp()->willReturn(1234567890);

        $this->setValue(new \DateTime('@9876543210'));

        $this->getValue()
            ->shouldReturnAnInstanceOf('DateTimeImmutable')
        ;

        $this->getValue()
            ->shouldBeTimestamp(9876543210)
        ;
    }
}
