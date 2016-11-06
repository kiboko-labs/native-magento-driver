<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoORM\Writer\Database;

use Doctrine\DBAL\Connection;

class MySQLDataInfileDatabaseWriter implements DatabaseWriterInterface
{
    use MySQLDataInfileDatabaseWriterTrait;

    /**
     * @var string
     */
    private $path;

    /**
     * DataInfileDatabaseWriter constructor.
     *
     * @param Connection $connection
     * @param string     $path
     * @param string     $delimiter
     * @param string     $enclosure
     * @param string     $escaper
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
     * @param string     $table
     * @param array      $tableFields
     * @param \Generator $messenger
     *
     * @return int
     */
    public function write($table, array $tableFields, \Generator $messenger = null)
    {
        return $this->doWrite('LOAD DATA INFILE', $this->path, $table, $tableFields, $messenger);
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
