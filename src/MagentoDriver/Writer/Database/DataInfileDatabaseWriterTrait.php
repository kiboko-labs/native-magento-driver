<?php

namespace Luni\Component\MagentoDriver\Writer\Database;

use Doctrine\DBAL\Connection;
use League\Flysystem\File;
use Luni\Component\MagentoDriver\Exception\RuntimeErrorException;

trait DataInfileDatabaseWriterTrait
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
     * @param string $prefix
     * @param File $file
     * @param string $table
     * @param array $tableFields
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    private function doWrite($prefix, File $file, $table, array $tableFields)
    {
        if (!$file->exists()) {
            throw new RuntimeErrorException(sprintf('File %s does not exist', $file->getPath()));
        }

        if ($file->getSize() <= 0) {
            return 0;
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

        if (($count = $this->connection->exec($query)) <= 0) {
            throw new RuntimeErrorException(sprintf('Failed to import data from file %s', $file->getPath()));
        }

        return $count;
    }
}