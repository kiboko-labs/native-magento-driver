<?php

namespace spec\Luni\Component\MagentoDriver\Persister\AttributeValue;

use League\Flysystem\FilesystemInterface;
use Luni\Component\MagentoDriver\Filesystem\FileMoverInterface;
use Luni\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Luni\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;
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
        $this->shouldHaveType('Luni\Component\MagentoDriver\Persister\AttributeValue\MediaGalleryAttributeValuePersister');
    }
}
