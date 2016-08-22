<?php

namespace Kiboko\Component\MagentoMapper\SchemaManager\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Schema\Table;
use Kiboko\Component\MagentoMapper\SchemaManager\MappingSchemaManagerInterface;

class FamilyMappingSchemaManager implements MappingSchemaManagerInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $tableName;

    /**
     * @var string
     */
    private $attributeSetsTableName;

    /**
     * OptionMappingSchemaManager constructor.
     *
     * @param Connection $connection
     * @param string     $tableName
     * @param string     $attributeSetsTableName
     */
    public function __construct(
        Connection $connection,
        $tableName,
        $attributeSetsTableName
    ) {
        $this->connection = $connection;
        $this->tableName = $tableName;
        $this->attributeSetsTableName = $attributeSetsTableName;
    }

    /**
     * @return bool
     */
    public function assertTableExists()
    {
        $manager = $this->connection->getSchemaManager();

        return $manager->tablesExist([$this->tableName]);
    }

    /**
     * @return Table
     */
    private function declareTableSchema()
    {
        $table = new Table($this->tableName);

        $table->addColumn('attribute_set_id', 'smallint', [
            'unsigned' => true,
        ]);

        $table->addColumn('instance_identifier', 'string', [
            'length' => 64
        ]);

        $table->addColumn('family_code', 'string', [
            'length' => 255,
        ]);

        $table->addColumn('mapping_class', 'string', [
            'length' => 255,
        ]);

        $table->addColumn('mapping_options', 'string', [
            'length' => 65536,
        ]);

        $table->addIndex(['attribute_set_id']);

        $table->addIndex(['family_code']);

        $table->addUniqueIndex(['instance_identifier', 'attribute_set_id']);

        $table->addForeignKeyConstraint(
            new Table($this->attributeSetsTableName),
            [
                'attribute_set_id',
            ],
            [
                'attribute_set_id',
            ],
            [
                'onUpdate' => 'CASCADE',
                'onDelete' => 'CASCADE',
            ]
        );

        return $table;
    }

    public function createTable()
    {
        $manager = $this->connection->getSchemaManager();

        $manager->createTable($this->declareTableSchema());
    }

    /**
     * @param string $pimgentoTableName
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function initializeFromPimgento($pimgentoTableName)
    {
        $manager = $this->connection->getSchemaManager();

        if (!$manager->tablesExist([$pimgentoTableName])) {
            return;
        }

        $queryBuilder = new QueryBuilder($this->connection);

        $queryBuilder
            ->select([
                'attribute_set_id' => 'pim.entity_id',
                'family_code' => 'pim.code',
            ])
            ->from($pimgentoTableName, 'pim')
            ->where($queryBuilder->expr()->eq('pim.import', '?'))
        ;

        return $this->connection->executeUpdate(
            "INSERT INTO {$this->connection->quoteIdentifier($this->tableName)} "
                .$queryBuilder->getSQL(),
            [
                'family',
            ]
        );
    }
}
