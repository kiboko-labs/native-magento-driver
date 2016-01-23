<?php

namespace Luni\Component\MagentoDriver\Writer\Database;

use Doctrine\DBAL\Connection;

class DataInfileDatabaseWriter
    implements DatabaseWriterInterface
{
    use DataInfileDatabaseWriterTrait;

    /**
     * @var string
     */
    private $path;

    /**
     * DataInfileDatabaseWriter constructor.
     * @param Connection $connection
     * @param string $path
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escaper
     */
    public function __construct(
        Connection $connection,
        $path,
        $delimiter = ';',
        $enclosure = '"',
        $escaper = '"'
    ) {
        $this->path = $path;
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
        return $this->doWrite('LOAD DATA INFILE', $this->path, $table, $tableFields);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }
}