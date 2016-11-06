<?php

namespace unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture;

use Doctrine\DBAL\Connection;

class DoctrineDataSet
    extends \PHPUnit_Extensions_Database_DataSet_AbstractDataSet
{
    /**
     * An array of ITable objects.
     *
     * @var array
     */
    protected $tables = [];

    /**
     * The database connection this dataset is using.
     *
     * @var Connection
     */
    protected $databaseConnection;

    /**
     * Creates a new dataset using the given database connection.
     *
     * @param Connection $databaseConnection
     */
    public function __construct(Connection $databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
    }

    public function addTable($tableName, $query = NULL)
    {
        if ($query === NULL) {
            $query = 'SELECT * FROM ' . $this->databaseConnection->quoteIdentifier($tableName);
        }

        $this->tables[$tableName] = new DoctrineQueryTable($tableName, $query, $this->databaseConnection);
    }

    /**
     * Creates an iterator over the tables in the data set. If $reverse is
     * true a reverse iterator will be returned.
     *
     * @param  bool                                         $reverse
     * @return \PHPUnit_Extensions_Database_DB_TableIterator
     */
    protected function createIterator($reverse = false)
    {
        return new \PHPUnit_Extensions_Database_DataSet_DefaultTableIterator($this->tables, $reverse);
    }

    /**
     * Returns a table object for the given table.
     *
     * @param  string                               $tableName
     * @return \PHPUnit_Extensions_Database_DB_Table
     */
    public function getTable($tableName)
    {
        if (!isset($this->tables[$tableName])) {
            throw new \InvalidArgumentException("$tableName is not a table in the current database.");
        }

        return $this->tables[$tableName];
    }

    /**
     * Returns a list of table names for the database
     *
     * @return array
     */
    public function getTableNames()
    {
        return array_keys($this->tables);
    }
}
