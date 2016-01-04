<?php

namespace Luni\Component\MagentoDriver\Writer\Database;

use Doctrine\DBAL\Connection;
use League\Flysystem\File;

class LocalDataInfileDatabaseWriter
    implements DatabaseWriterInterface
{
    use DataInfileDatabaseWriterTrait;

    /**
     * @var File
     */
    private $file;

    /**
     * DataInfileDatabaseWriter constructor.
     * @param Connection $connection
     * @param File $file
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escaper
     */
    public function __construct(
        Connection $connection,
        File $file = null,
        $delimiter = ';',
        $enclosure = '"',
        $escaper = '"'
    ) {
        $this->file = $file;
        $this->connection = $connection;
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->escaper = $escaper;
    }

    /**
     * @param string $table
     * @param array $tableFields
     * @return int
     */
    public function write($table, array $tableFields)
    {
        return $this->doWrite('LOAD DATA LOCAL INFILE', $this->file, $table, $tableFields);
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

    /**
     * @return string
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * @param string $delimiter
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
    }

    /**
     * @return string
     */
    public function getEnclosure()
    {
        return $this->enclosure;
    }

    /**
     * @param string $enclosure
     */
    public function setEnclosure($enclosure)
    {
        $this->enclosure = $enclosure;
    }

    /**
     * @return string
     */
    public function getEscaper()
    {
        return $this->escaper;
    }

    /**
     * @param string $escaper
     */
    public function setEscaper($escaper)
    {
        $this->escaper = $escaper;
    }
}