<?php

namespace spec\Kiboko\Component\MagentoDriver\Persister\FlatFile\AttributeValue;

use League\Flysystem\FilesystemInterface;
use Kiboko\Component\MagentoDriver\Filesystem\FileMoverInterface;
use Kiboko\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Kiboko\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;
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
        $this->shouldHaveType('Kiboko\Component\MagentoDriver\Persister\FlatFile\AttributeValue\MediaGalleryAttributeValuePersister');
    }
}
