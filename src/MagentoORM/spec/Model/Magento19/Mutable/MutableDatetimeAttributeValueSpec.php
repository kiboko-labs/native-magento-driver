<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace spec\Kiboko\Component\MagentoORM\Model\Magento19\Mutable;

use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use PhpSpec\ObjectBehavior;

class MutableDatetimeAttributeValueSpec extends ObjectBehavior
{
    public function getMatchers()
    {
        return [
            'beTimestamp' => function (\DateTimeInterface $subject, $timestamp) {
                return $subject->getTimestamp() === $timestamp;
            },
        ];
    }

    public function it_is_an_MutableAttributeValueInterface(AttributeInterface $attribute, \DateTimeImmutable $datetime)
    {
        $this->beConstructedWith($attribute, $datetime);
        $this->shouldImplement('Kiboko\Component\MagentoORM\Model\Magento19\MutableAttributeValueInterface');
    }

    public function it_should_contain_immutable_datetime_value(AttributeInterface $attribute, \DateTimeImmutable $datetime)
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

    public function it_should_be_mutable(AttributeInterface $attribute, \DateTimeImmutable $datetime)
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
