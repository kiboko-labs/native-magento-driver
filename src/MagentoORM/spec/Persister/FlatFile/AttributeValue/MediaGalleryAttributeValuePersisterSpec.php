<?php

namespace spec\Kiboko\Component\MagentoORM\Persister\FlatFile\AttributeValue;

use League\Flysystem\FilesystemInterface;
use Kiboko\Component\MagentoORM\Filesystem\FileMoverInterface;
use Kiboko\Component\MagentoORM\Writer\Database\DatabaseWriterInterface;
use Kiboko\Component\MagentoORM\Writer\Temporary\TemporaryWriterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MediaGalleryAttributeValuePersisterSpec extends ObjectBehavior
{
    function it_is_initializable(
        TemporaryWriterInterface $temporaryImageWriter,
        TemporaryWriterInterface $temporaryLocaleWriter,
        DatabaseWriterInterface $databaseImagesWriter,
        DatabaseWriterInterface $databaseLocaleWriter,
        FileMoverInterface $fileMover,
        FilesystemInterface $imagesFs,
        FilesystemInterface $remoteFs
    ) {
        $this->beConstructedWith(
            $temporaryImageWriter,
            $temporaryLocaleWriter,
            $databaseImagesWriter,
            $databaseLocaleWriter,
            $fileMover,
            'images_table',
            'locales_table',
            $imagesFs,
            $remoteFs
        );
        $this->shouldHaveType('Kiboko\Component\MagentoORM\Persister\FlatFile\AttributeValue\MediaGalleryAttributeValuePersister');
    }
}
