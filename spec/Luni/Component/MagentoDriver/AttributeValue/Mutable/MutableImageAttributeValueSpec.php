<?php

namespace spec\Luni\Component\MagentoDriver\AttributeValue\Mutable;

use League\Flysystem\Adapter\NullAdapter;
use League\Flysystem\File;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MutableImageAttributeValueSpec extends ObjectBehavior
{
    public function getMatchers()
    {
        return [
            'bePath' => function(File $subject, $path) {
                return $subject->getPath() === $path;
            },
            'beFilesystem' => function(File $subject, Filesystem $filesystem) {
                return $subject->getFilesystem() === $filesystem;
            },
        ];
    }

    function it_is_an_MutableAttributeValueInterface(AttributeInterface $attribute, File $file)
    {
        $this->beConstructedWith($attribute, $file);
        $this->shouldImplement('Luni\Component\MagentoDriver\AttributeValue\Mutable\MutableAttributeValueInterface');
    }

    function it_should_contain_flysystem_file_value(AttributeInterface $attribute,  File $file)
    {
        $this->beConstructedWith($attribute, $file);

        $this->getFile()
            ->shouldReturnAnInstanceOf('League\\Flysystem\\File')
        ;
    }

    function it_should_be_mutable(AttributeInterface $attribute, File $file)
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
