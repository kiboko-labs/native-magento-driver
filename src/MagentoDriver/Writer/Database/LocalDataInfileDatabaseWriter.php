<?php

namespace Luni\Component\MagentoDriver\Writer\Database;

use Doctrine\DBAL\Connection;
use League\Flysystem\Adapter\AbstractAdapter;
use League\Flysystem\File;
use League\Flysystem\Filesystem;
use Luni\Component\MagentoDriver\Exception\InvalidArgumentException;

class LocalDataInfileDatabaseWriter implements DatabaseWriterInterface
{
    use DataInfileDatabaseWriterTrait;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var File
     */
    private $file;

    /**
     * DataInfileDatabaseWriter constructor.
     *
     * @param Connection $connection
     * @param Filesystem $filesystem
     * @param File       $file
     * @param string     $delimiter
     * @param string     $enclosure
     * @param string     $escaper
     */
    public function __construct(
        Connection $connection,
        Filesystem $filesystem,
        File $file = null,
        $delimiter = ';',
        $enclosure = '"',
        $escaper = '"'
    ) {
        $this->filesystem = $filesystem;
        $this->file = $file;
        $this->connection = $connection;
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->escaper = $escaper;
    }

    /**
     * @param string     $table
     * @param array      $tableFields
     * @param \Generator $messenger
     *
     * @return int
     */
    public function write($table, array $tableFields, \Generator $messenger = null)
    {
        $adapter = $this->filesystem->getAdapter();
        if (!$adapter instanceof AbstractAdapter) {
            throw new InvalidArgumentException('Could not determine the file path.');
        }

        $path = $adapter->applyPathPrefix($this->file->getPath());
        $count = $this->doWrite('LOAD DATA LOCAL INFILE', $path, $table, $tableFields, $messenger);

        $this->file->delete();

        return $count;
    }

    /**
     * @return Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * @param Filesystem $filesystem
     */
    public function setFilesystem($filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param File $file
     */
    public function setFile(File $file)
    {
        $this->file = $file;
    }
}
