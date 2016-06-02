<?php

namespace spec\Kiboko\Component\MagentoDriver\Model\Immutable;

use League\Flysystem\File;
use Kiboko\Component\MagentoDriver\Model\AttributeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImmutableImageAttributeValueSpec extends ObjectBehavior
{
    function it_is_an_ImmutableAttributeValueInterface(AttributeInterface $attribute, File $file)
    {
        $this->beConstructedWith($attribute, $file);
        $this->shouldImplement('Kiboko\Component\MagentoDriver\Model\Immutable\ImmutableAttributeValueInterface');
    }

    function it_should_contain_flysystem_file_value(AttributeInterface $attribute,  File $file)
    {
        $this->beConstructedWith($attribute, $file);

        $this->getFile()
            ->shouldReturnAnInstanceOf('League\\Flysystem\\File')
        ;
    }
}