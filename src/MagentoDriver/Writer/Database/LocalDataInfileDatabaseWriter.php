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
     * @param File $file
     * @param Connection $connection
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escaper
     */
    public function __construct(
        File $file,
        Connection $connection,
        $delimiter,
        $enclosure,
        $escaper
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
}