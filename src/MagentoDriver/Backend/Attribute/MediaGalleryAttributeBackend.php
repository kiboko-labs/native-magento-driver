<?php

namespace Luni\Component\MagentoDriver\Backend\Attribute;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use League\Flysystem\File;
use League\Flysystem\FilesystemInterface;
use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\ImageAttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\ImageMetadataAttributeValueInterface;
use Luni\Component\MagentoDriver\AttributeValue\MediaGalleryAttributeValueInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\Exception\InvalidAttributeBackendTypeException;
use Luni\Component\MagentoDriver\Exception\RuntimeErrorException;
use Luni\Component\MagentoDriver\Filesystem\FileMoverInterface;
use Luni\Component\MagentoDriver\Writer\Database\DatabaseWriterInterface;
use Luni\Component\MagentoDriver\Writer\Temporary\TemporaryWriterInterface;

class MediaGalleryAttributeBackend
    implements BackendInterface
{
    /**
     * @var TemporaryWriterInterface
     */
    private $temporaryImageWriter;

    /**
     * @var TemporaryWriterInterface
     */
    private $temporaryLocaleWriter;

    /**
     * @var DatabaseWriterInterface
     */
    private $databaseImagesWriter;

    /**
     * @var DatabaseWriterInterface
     */
    private $databaseLocaleWriter;

    /**
     * @var FileMoverInterface
     */
    private $fileMover;

    /**
     * @var FilesystemInterface
     */
    private $imagesFs;

    /**
     * @var FilesystemInterface
     */
    private $remoteFs;

    /**
     * @var array
     */
    private $imageTableKeys = [
        'value_id',
        'entity_type_id',
        'attribute_id',
        'store_id',
        'entity_id',
        'value',
    ];

    /**
     * @var array
     */
    private $localeTableKeys = [
        'value_id',
        'entity_type_id',
        'attribute_id',
        'store_id',
        'entity_id',
        'value',
    ];

    /**
     * @var string
     */
    private $imageTableName;

    /**
     * @var string
     */
    private $localeTableName;

    /**
     * @var Collection
     */
    private $imagesList;

    /**
     * @var File
     */
    protected $tmpImagesFile;

    /**
     * @var File
     */
    protected $tmpLocalesFile;

    /**
     * @param TemporaryWriterInterface $temporaryImageWriter
     * @param TemporaryWriterInterface $temporaryLocaleWriter
     * @param DatabaseWriterInterface $databaseImagesWriter
     * @param DatabaseWriterInterface $databaseLocaleWriter
     * @param FileMoverInterface $fileMover
     * @param string $imageTableName
     * @param string $localeTableName
     * @param FilesystemInterface $imagesFs
     * @param FilesystemInterface $remoteFs
     */
    public function __construct(
        TemporaryWriterInterface $temporaryImageWriter,
        TemporaryWriterInterface $temporaryLocaleWriter,
        DatabaseWriterInterface $databaseImagesWriter,
        DatabaseWriterInterface $databaseLocaleWriter,
        FileMoverInterface $fileMover,
        $imageTableName,
        $localeTableName,
        FilesystemInterface $imagesFs,
        FilesystemInterface $remoteFs
    ) {
        $this->temporaryImageWriter = $temporaryImageWriter;
        $this->temporaryLocaleWriter = $temporaryLocaleWriter;
        $this->databaseImagesWriter = $databaseImagesWriter;
        $this->databaseLocaleWriter = $databaseLocaleWriter;
        $this->fileMover = $fileMover;
        $this->imageTableName = $imageTableName;
        $this->localeTableName = $localeTableName;
        $this->remoteFs = $remoteFs;
        $this->imagesFs = $imagesFs;
        $this->imagesList = new ArrayCollection();
    }

    /**
     * @throws RuntimeErrorException
     */
    public function initialize()
    {
    }

    public function persist(ProductInterface $product, AttributeValueInterface $value)
    {
        if (!$value instanceof MediaGalleryAttributeValueInterface) {
            throw new InvalidAttributeBackendTypeException();
        }

        /** @var ImageAttributeValueInterface $mediaAsset */
        foreach ($value as $mediaAsset) {
            $this->temporaryImageWriter->persistRow([
                'value_id'     => $mediaAsset->getId(),
                'attribute_id' => $mediaAsset->getAttributeId(),
                'entity_id'    => $product->getId(),
                'value'        => $mediaAsset->getFile()->getPath(),
            ]);

            /** @var ImageMetadataAttributeValueInterface $metadata */
            foreach ($mediaAsset->getMetadata() as $metadata) {
                $this->temporaryLocaleWriter->persistRow([
                    'value_id' => $mediaAsset->getId(),
                    'store_id' => $metadata->getStoreId(),
                    'label'    => $metadata->getLabel(),
                    'position' => $metadata->getPosition(),
                    'disabled' => $metadata->isExcluded(),
                ]);
            }
        }
    }

    /**
     * Flushes data into the DB
     */
    public function flush()
    {
        $this->temporaryImageWriter->flush();
        $this->temporaryLocaleWriter->flush();

        $this->databaseImagesWriter->write($this->imageTableName, $this->imageTableKeys);
        $this->databaseLocaleWriter->write($this->localeTableName, $this->localeTableKeys);

        $this->fileMover->move($this->imagesFs, $this->remoteFs, $this->imagesList);
        $this->imagesList->clear();
    }
}