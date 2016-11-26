<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace spec\Kiboko\Component\MagentoORM\Model\Magento20\Mutable;

use League\Flysystem\Adapter\NullAdapter;
use League\Flysystem\File;
use League\Flysystem\Filesystem;
use Kiboko\Component\MagentoORM\Model\AttributeInterface;
use PhpSpec\ObjectBehavior;

class MutableImageAttributeValueSpec extends ObjectBehavior
{
    public function getMatchers()
    {
        return [
            'bePath' => function (File $subject, $path) {
                return $subject->getPath() === $path;
            },
            'beFilesystem' => function (File $subject, Filesystem $filesystem) {
                return $subject->getFilesystem() === $filesystem;
            },
        ];
    }

    public function it_is_an_MutableAttributeValueInterface(AttributeInterface $attribute, File $file)
    {
        $this->beConstructedWith($attribute, $file);
        $this->shouldImplement('Kiboko\Component\MagentoORM\Model\Magento20\MutableAttributeValueInterface');
    }

    public function it_should_contain_flysystem_file_value(AttributeInterface $attribute,  File $file)
    {
        $this->beConstructedWith($attribute, $file);

        $this->getFile()
            ->shouldReturnAnInstanceOf('League\\Flysystem\\File')
        ;
    }

    public function it_should_be_mutable(AttributeInterface $attribute, File $file)
    {
        $filesystem = new Filesystem(new NullAdapter());

        $file->getPath()->willReturn('random/path.txt');
        $file->getFilesystem()->willReturn($filesystem);

        $this->beConstructedWith($attribute, $file);

        $newFile = new File($filesystem, 'another/path.txt');

        $this->setFile($newFile);

        $this->getFile()
            ->shouldReturnAnInstanceOf('League\\Flysystem\\File')
        ;

        $this->getFile()
            ->shouldNotReturn($file)
        ;

        $this->getFile()
            ->shouldBePath('another/path.txt')
        ;

        $this->getFile()
            ->shouldBeFilesystem($filesystem)
        ;
    }
}
