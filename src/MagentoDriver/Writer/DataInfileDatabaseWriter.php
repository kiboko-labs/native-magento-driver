<?php

namespace Luni\Component\MagentoDriver\Writer;


use Doctrine\DBAL\Connection;
use League\Flysystem\File;
use Luni\Component\MagentoDriver\Exception\RuntimeErrorException;

class DataInfileDatabaseWriter
    implements DatabaseWriterInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $delimiter;

    /**
     * @var string
     */
    private $enclosure;

    /**
     * @var string
     */
    private $escaper;

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

    /**
     * @param File $file
     * @param string $table
     * @param array $tableFields
     */
    public function writeFromLocalFile(File $file, $table, array $tableFields)
    {
        $this->doWriteFromFile('LOAD DATA LOCAL INFILE', $file, $table, $tableFields);
    }

    /**
     * @param string $prefix
     * @param File $file
     * @param string $table
     * @param array $tableFields
     * @throws \Doctrine\DBAL\DBALException
     */
    private function doWriteFromFile($prefix, File $file, $table, array $tableFields)
    {
        if (!$file->exists()) {
            throw new RuntimeErrorException(sprintf('File %s does not exist', $file->getPath()));
        }

        $keys = [];
        foreach ($tableFields as $key) {
            $keys[] = $this->connection->quoteIdentifier($key);
        }
        $serializedKeys = implode(',', $keys);

        $query =<<<SQL_EOF
{$prefix} {$this->connection->quote($file->getPath())}
REPLACE INTO TABLE {$this->connection->quoteIdentifier($table)}
FIELDS
    TERMINATED BY {$this->connection->quote($this->delimiter)}
    OPTIONALLY ENCLOSED BY {$this->connection->quote($this->enclosure)}
    ESCAPED BY {$this->connection->quote($this->escaper)}
({$serializedKeys})
SQL_EOF;

        if ($this->connection->exec($query) <= 0) {
            throw new RuntimeErrorException(sprintf('Failed to import data from file %s', $file->getPath()));
        }
    }
}