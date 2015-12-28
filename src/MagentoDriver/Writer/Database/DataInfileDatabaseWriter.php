<?php

namespace Luni\Component\MagentoDriver\Writer\Database;

use Doctrine\DBAL\Connection;
use League\Flysystem\File;

class DataInfileDatabaseWriter
    implements DatabaseWriterInterface
{
    use DataInfileDatabaseWriterTrait;

    /**
     * DataInfileDatabaseWriter constructor.
     * @param Connection $connection
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escaper
     */
    public function __construct(
        Connection $connection,
        $delimiter,
        $enclosure,
        $escaper
    ) {
        $this->connection = $connection;
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->escaper = $escaper;
    }

    /**
     * @param File $file
     * @param string $table
     * @param array $tableFields
     */
    public function writeFromFile(File $file, $table, array $tableFields)
    {
        $this->doWriteFromFile('LOAD DATA INFILE', $file, $table, $tableFields);
    }
}