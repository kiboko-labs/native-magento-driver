<?php
/**
 * Copyright (c) 2016 Kiboko SAS
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoMapper\SchemaManager\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaDiff;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Schema\Comparator as SchemaComparator;
use Kiboko\Component\MagentoMapper\SchemaManager\MappingSchemaManagerInterface;

abstract class AbstractMappingSchemaManager implements MappingSchemaManagerInterface
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var SchemaComparator
     */
    protected $schemaComparator;

    /**
     * @var string
     */
    protected $tableName;

    /**
     * OptionMappingSchemaManager constructor.
     *
     * @param Connection       $connection
     * @param SchemaComparator $schemaComparator
     * @param string           $tableName
     */
    public function __construct(
        Connection $connection,
        SchemaComparator $schemaComparator,
        $tableName
    ) {
        $this->connection = $connection;
        $this->schemaComparator = $schemaComparator;
        $this->tableName = $tableName;
    }

    /**
     * @param Schema $currentSchema
     * @param SchemaDiff $schemaDiff
     * @return SchemaDiff
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function schemaDiff(Schema $currentSchema, SchemaDiff $schemaDiff)
    {
        $table = $this->declareTable();

        if (!$currentSchema->hasTable($this->tableName)) {
            $schemaDiff->newTables[$table->getName()] = $table;
        } else {
            $tableDifferences = $this->schemaComparator->diffTable(
                $currentSchema->getTable($this->tableName),
                $table
            );

            if ($tableDifferences !== false) {
                $schemaDiff->changedTables[$this->tableName] = $tableDifferences;
            }
        }

        return $schemaDiff;
    }

    /**
     * @return Table
     */
    abstract protected function declareTable();

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }
}
