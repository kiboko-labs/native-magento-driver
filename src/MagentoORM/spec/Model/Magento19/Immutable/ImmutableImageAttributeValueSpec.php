<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace spec\Kiboko\Component\MagentoORM\Model\V1_9ce\Immutable;

use League\Flysystem\File;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use PhpSpec\ObjectBehavior;

class ImmutableImageAttributeValueSpec extends ObjectBehavior
{
    public function it_is_an_ImmutableAttributeValueInterface(AttributeInterface $attribute, File $file)
    {
        $this->beConstructedWith($attribute, $file);
        $this->shouldImplement('Kiboko\Component\MagentoORM\Model\V1_9ce\ImmutableAttributeValueInterface');
    }

    public function it_should_contain_flysystem_file_value(AttributeInterface $attribute,  File $file)
    {
        $this->beConstructedWith($attribute, $file);

        $this->getFile()
            ->shouldReturnAnInstanceOf('League\\Flysystem\\File')
        ;
    }
}
