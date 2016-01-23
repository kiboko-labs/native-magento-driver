<?php

namespace Luni\Component\MagentoDriver\Writer\Database;

use Doctrine\DBAL\Connection;
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
     * @param string $path
     * @param string $table
     * @param array $tableFields
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    private function doWrite($prefix, $path, $table, array $tableFields)
    {
        $keys = [];
        foreach ($tableFields as $key) {
            $keys[] = $this->connection->quoteIdentifier($key);
        }
        $serializedKeys = implode(',', $keys);

        $query =<<<SQL_EOF
{$prefix} {$this->connection->quote($path)}
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