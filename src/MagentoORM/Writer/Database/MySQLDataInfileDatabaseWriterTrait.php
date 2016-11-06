<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Writer\Database;

use Doctrine\DBAL\Connection;
use Kiboko\Component\MagentoORM\Exception\RuntimeErrorException;

trait MySQLDataInfileDatabaseWriterTrait
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
     * @var int[]
     */
    private $insertedIds = [];

    /**
     * @param string     $prefix
     * @param string     $path
     * @param string     $table
     * @param array      $tableFields
     * @param \Generator $messenger
     *
     * @return int
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    private function doWrite($prefix, $path, $table, array $tableFields, \Generator $messenger = null)
    {
        $keys = [];
        foreach ($tableFields as $key) {
            $keys[] = $this->connection->quoteIdentifier($key);
        }
        $serializedKeys = implode(',', $keys);

        $statement = $this->connection
            ->executeQuery('SELECT @@SESSION.sql_mode');
        $statement->execute();
        $originalModes = explode(',', $statement->fetchColumn());
        if (!in_array('NO_AUTO_VALUE_ON_ZERO', $originalModes)) {
            $this->connection->exec(sprintf('SET SESSION sql_mode="%s"',
                implode(',', array_merge($originalModes, ['NO_AUTO_VALUE_ON_ZERO']))
            ));
        }

        $query = <<<SQL_EOF
{$prefix} {$this->connection->quote($path)}
REPLACE INTO TABLE {$this->connection->quoteIdentifier($table)}
FIELDS
    TERMINATED BY {$this->connection->quote($this->delimiter)}
    OPTIONALLY ENCLOSED BY {$this->connection->quote($this->enclosure)}
    ESCAPED BY {$this->connection->quote($this->escaper)}
({$serializedKeys})
SQL_EOF;

        if (($count = $this->connection->exec($query)) < 0) {
            if (!in_array('NO_AUTO_VALUE_ON_ZERO', $originalModes)) {
                $this->connection->exec(sprintf('SET SESSION sql_mode="%s"',
                    implode(',', $originalModes)
                ));
            }

            throw new RuntimeErrorException(sprintf('Failed to import data from file %s', $path));
        }

        if (!in_array('NO_AUTO_VALUE_ON_ZERO', $originalModes)) {
            $this->connection->exec(sprintf('SET SESSION sql_mode="%s"',
                implode(',', $originalModes)
            ));
        }

        if ($messenger !== null) {
            // $this->connection->lastInertId() seems to be buggy with MariaDB 10.0.15
            $statement = $this->connection
                ->executeQuery('SELECT LAST_INSERT_ID()');
            $statement->execute();
            $lastId = $statement->fetchColumn();

            for ($identifier = 0; $identifier < $count; ++$identifier) {
                $messenger->send($lastId + $identifier);
            }
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
