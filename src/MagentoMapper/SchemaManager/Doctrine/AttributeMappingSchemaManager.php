<?php

namespace Kiboko\Component\MagentoMapper\SchemaManager\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaDiff;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Schema\Comparator as SchemaComparator;

class AttributeMappingSchemaManager extends AbstractMappingSchemaManager
{
    /**
     * @var string
     */
    private $attributesTableName;

    /**
     * OptionMappingSchemaManager constructor.
     *
     * @param Connection       $connection
     * @param SchemaComparator $schemaComparator
     * @param string           $tableName
     * @param string           $attributesTableName
     */
    public function __construct(
        Connection $connection,
        SchemaComparator $schemaComparator,
        $tableName,
        $attributesTableName
    ) {
        parent::__construct($connection, $schemaComparator, $tableName);
        $this->attributesTableName = $attributesTableName;
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
    protected function declareTable()
    {
        $table = new Table($this->tableName);

        $table->addColumn('attribute_id', 'smallint', [
            'unsigned' => true,
        ]);

        $table->addColumn('instance_identifier', 'string', [
            'length' => 64
        ]);

        $table->addColumn('attribute_code', 'string', [
            'length' => 255,
        ]);

        $table->addColumn('mapping_class', 'string', [
            'length' => 255,
        ]);

        $table->addColumn('mapping_options', 'string', [
            'length' => 65536,
        ]);

        $table->addIndex(['attribute_id']);

        $table->addIndex(['attribute_code']);

        $table->addUniqueIndex(['instance_identifier', 'attribute_id']);

        $table->addForeignKeyConstraint(
            $this->attributesTableName,
            [
                'attribute_id',
            ],
            [
                'attribute_id',
            ],
            [
                'onUpdate' => 'CASCADE',
                'onDelete' => 'CASCADE',
            ]
        );

        return $table;
    }

    /**
     * @param string $pimgentoTableName
     * @param string $linkCode
     * @return int
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function initializeFromPimgento($pimgentoTableName, $linkCode)
    {
        $manager = $this->connection->getSchemaManager();

        if (!$manager->tablesExist([$pimgentoTableName])) {
            return;
        }

        $queryBuilder = new QueryBuilder($this->connection);

        $queryBuilder
            ->select([
                'attribute_id'        => 'pim.entity_id',
                'instance_identifier' => $queryBuilder->expr()->literal($linkCode),
                'attribute_code'      => 'pim.code',
                'mapping_class'       => 'NULL',
                'mapping_options'     => $queryBuilder->expr()->literal(json_encode([], JSON_OBJECT_AS_ARRAY)),
            ])
            ->from($pimgentoTableName, 'pim')
            ->where($queryBuilder->expr()->eq('pim.import', '?'))
        ;

        return $this->connection->executeUpdate(
            "INSERT INTO {$this->connection->quoteIdentifier($this->tableName)} "
                .$queryBuilder->getSQL(),
            [
                'attribute',
            ]
        );
    }
}
