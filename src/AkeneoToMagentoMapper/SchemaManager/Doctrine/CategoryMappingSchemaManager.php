<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\AkeneoToMagentoMapper\SchemaManager\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Schema\Table;
use Kiboko\Component\AkeneoToMagentoMapper\SchemaManager\MappingSchemaManagerInterface;

class CategoryMappingSchemaManager implements MappingSchemaManagerInterface
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
    private $categoriesTableName;

    /**
     * OptionMappingSchemaManager constructor.
     *
     * @param Connection $connection
     * @param string     $tableName
     * @param string     $categoriesTableName
     */
    public function __construct(
        Connection $connection,
        $tableName,
        $categoriesTableName
    ) {
        $this->connection = $connection;
        $this->tableName = $tableName;
        $this->categoriesTableName = $categoriesTableName;
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

        $table->addColumn('category_id', 'smallint', [
            'unsigned' => true,
        ]);

        $table->addColumn('instance_identifier', 'string', [
            'length' => 64,
        ]);

        $table->addColumn('category_code', 'string', [
            'length' => 255,
        ]);

        $table->addColumn('mapping_class', 'string', [
            'length' => 255,
        ]);

        $table->addColumn('mapping_options', 'text');

        $table->addIndex(['category_id']);

        $table->addIndex(['category_code']);

        $table->addUniqueIndex(['instance_identifier', 'category_id']);

        $table->addForeignKeyConstraint(
            new Table($this->categoriesTableName),
            [
                'category_id',
            ],
            [
                'entity_id',
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
                'attribute_id' => 'pim.entity_id',
                'attribute_code' => 'pim.code',
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
