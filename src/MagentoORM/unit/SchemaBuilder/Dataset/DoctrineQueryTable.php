<?php

namespace unit\Kiboko\Component\MagentoORM\SchemaBuilder\Fixture;

use Doctrine\DBAL\Connection;

class DoctrineQueryTable extends \PHPUnit_Extensions_Database_DataSet_AbstractTable
{
    /**
     * @var string
     */
    protected $query;

    /**
     * @var Connection
     */
    protected $databaseConnection;

    /**
     * @var string
     */
    protected $tableName;

    /**
     * Creates a new database query table object.
     *
     * @param string     $tableName
     * @param string     $query
     * @param Connection $databaseConnection
     */
    public function __construct($tableName, $query, Connection $databaseConnection)
    {
        $this->query              = $query;
        $this->databaseConnection = $databaseConnection;
        $this->tableName          = $tableName;
    }

    /**
     * Returns the table's meta data.
     *
     * @return \PHPUnit_Extensions_Database_DataSet_ITableMetaData
     */
    public function getTableMetaData()
    {
        $this->createTableMetaData();

        return parent::getTableMetaData();
    }

    /**
     * Checks if a given row is in the table
     *
     * @param array $row
     *
     * @return bool
     */
    public function assertContainsRow(Array $row)
    {
        $this->loadData();

        return parent::assertContainsRow($row);
    }

    /**
     * Returns the number of rows in this table.
     *
     * @return int
     */
    public function getRowCount()
    {
        $this->loadData();

        return parent::getRowCount();
    }

    /**
     * Returns the value for the given column on the given row.
     *
     * @param int $row
     * @param int $column
     * @return null|string
     */
    public function getValue($row, $column)
    {
        $this->loadData();

        return parent::getValue($row, $column);
    }

    /**
     * Returns the an associative array keyed by columns for the given row.
     *
     * @param  int   $row
     * @return array
     */
    public function getRow($row)
    {
        $this->loadData();

        return parent::getRow($row);
    }

    /**
     * Asserts that the given table matches this table.
     *
     * @param \PHPUnit_Extensions_Database_DataSet_ITable $other
     * @return bool
     */
    public function matches(\PHPUnit_Extensions_Database_DataSet_ITable $other)
    {
        $this->loadData();

        return parent::matches($other);
    }

    protected function loadData()
    {
        if ($this->data === NULL) {
            $statement = $this->databaseConnection->query($this->query);
            $this->data = $statement->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    protected function createTableMetaData()
    {
        if ($this->tableMetaData === NULL) {
            $this->loadData();

            // if some rows are in the table
            $columns = [];
            if (isset($this->data[0])) {
                // get column names from data
                $columns = array_keys($this->data[0]);
            } else {
                // if no rows found, get column names from database
                $statement = $this->databaseConnection
                    ->prepare('SELECT column_name FROM information_schema.COLUMNS WHERE table_schema=:schema AND table_name=:table');
                $statement->execute([
                    'table'  => $this->tableName,
                    'schema' => $this->databaseConnection->getSchema()
                ]);

                $columns = $statement->fetchAll(\PDO::FETCH_COLUMN, 0);
            }
            // create metadata
            $this->tableMetaData = new \PHPUnit_Extensions_Database_DataSet_DefaultTableMetaData($this->tableName, $columns);
        }
    }
}
