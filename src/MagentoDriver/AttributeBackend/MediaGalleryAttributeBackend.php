<?php

namespace Luni\Component\MagentoDriver\AttributeBackend;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Connection;
use League\Flysystem\Filesystem as RemoteFilesystem;
use Luni\Component\MagentoDriver\Attribute\AttributeInterface;
use Luni\Component\MagentoDriver\AttributeValue\MediaGalleryAttributeValueInterface;
use Luni\Component\MagentoDriver\Entity\ProductInterface;
use Luni\Component\MagentoDriver\AttributeValue\AttributeValueInterface;
use Luni\Component\MagentoDriver\Exception\RuntimeErrorException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Security\Core\Util\ClassUtils;

class MediaGalleryAttributeBackend
    implements BackendInterface
{
    use AttributeBackendTrait;

    /**
     * @var RemoteFilesystem
     */
    private $remote;

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
    private $imagesPaths;

    /**
     * @var resource
     */
    protected $tmpImagesFile;

    /**
     * @var resource
     */
    protected $tmpLocalesFile;

    /**
     * @var string
     */
    private $delimiter = ';';

    /**
     * @var string
     */
    private $enclosure = '"';

    /**
     * @var string
     */
    private $escaper = '"';

    /**
     * @param Connection $connection
     * @param RemoteFilesystem $remote
     * @param string $basePath
     * @param string $imageTableName
     * @param string $localeTableName
     */
    public function __construct(
        Connection $connection,
        RemoteFilesystem $remote,
        $basePath,
        $imageTableName,
        $localeTableName
    ) {
        $this->connection = $connection;
        $this->remote = $remote;
        $this->basePath = $basePath;
        $this->imageTableName = $imageTableName;
        $this->localeTableName = $localeTableName;

        $this->localFs = new Filesystem();
        $this->imagesPaths = new ArrayCollection();
    }

    /**
     * Flushes data into the DB
     */
    public function flush()
    {
        $this->flushInto($this->tmpImagesFile, $this->imageTableName, $this->imageTableKeys);
        $this->flushInto($this->tmpLocalesFile, $this->localeTableName, $this->localeTableKeys);

        $this->moveImages();
    }

    /**
     * @param $filename
     * @param $table
     * @param array $tableFields
     * @throws \Doctrine\DBAL\DBALException
     */
    public function flushInto($filename, $table, array $tableFields)
    {
        if (!$filename) {
            return;
        }

        if (false === fclose($filename)) {
            throw new RuntimeErrorException(sprintf('Failed to close file %s', $filename));
        }

        $keys = [];
        foreach ($tableFields as $key) {
            $keys[] = $this->connection->quoteIdentifier($key);
        }
        $serializedKeys = implode(',', $keys);

        $query =<<<SQL_EOF
LOAD DATA LOCAL INFILE {$this->connection->quote($filename)}
REPLACE INTO TABLE {$this->connection->quoteIdentifier($table)}
FIELDS
    TERMINATED BY {$this->connection->quote($this->delimiter)}
    OPTIONALLY ENCLOSED BY {$this->connection->quote($this->enclosure)}
    ESCAPED BY {$this->connection->quote($this->escaper)}
({$serializedKeys})
SQL_EOF;

        if ($this->connection->exec($query) <= 0) {
            throw new RuntimeErrorException(sprintf('Failed to import data from file %s', $filename));
        }

        $this->localFs->remove($filename);
    }

    public function moveImages()
    {
        /** @var \SplFileInfo $path */
        foreach ($this->imagesPaths as $path) {
            $this->remote->putStream($this->getImagePath($path), $fp = fopen($path->getPathname(), 'r'));
            fclose($fp);
        }

        $this->imagesPaths->clear();
    }

    private function getImagePath(\SplFileInfo $fileInfo)
    {
        $path = $fileInfo->getPathname();
        if ($path[0] !== '/') {
            return $path;
        }

        if (($offset = strpos($path, $this->basePath)) === false) {
            return $path;
        }

        if ($path[$offset] !== '/') {
            return $path;
        }

        return substr($path, $offset + 1);
    }
}