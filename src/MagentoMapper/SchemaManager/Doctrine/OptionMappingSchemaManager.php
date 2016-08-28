<?php

namespace Kiboko\Component\MagentoMapper\SchemaManager\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Schema\Table;
use Kiboko\Component\MagentoMapper\SchemaManager\MappingSchemaManagerInterface;

class OptionMappingSchemaManager implements MappingSchemaManagerInterface
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
    private $optionsTableName;

    /**
     * @var string
     */
    private $attributesTableName;

    /**
     * OptionMappingSchemaManager constructor.
     *
     * @param Connection $connection
     * @param string     $tableName
     * @param string     $optionsTableName
     * @param string     $attributesTableName
     */
    public function __construct(
        Connection $connection,
        $tableName,
        $optionsTableName,
        $attributesTableName
    ) {
        $this->connection = $connection;
        $this->tableName = $tableName;
        $this->optionsTableName = $optionsTableName;
        $this->attributesTableName = $attributesTableName;
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

        $table->addColumn('option_id', 'integer', [
            'unsigned' => true,
        ]);

        $table->addColumn('attribute_id', 'smallint', [
            'unsigned' => true,
        ]);

        $table->addColumn('instance_identifier', 'string', [
            'length' => 64
        ]);

        $table->addColumn('option_code', 'string', [
            'length' => 255,
        ]);

        $table->addColumn('mapping_class', 'string', [
            'length' => 255,
        ]);

        $table->addColumn('mapping_options', 'text');

        $table->addIndex(['option_id']);

        $table->addIndex(['attribute_id']);

        $table->addIndex(['option_code']);

        $table->addUniqueIndex(['instance_identifier', 'option_id', 'attribute_id']);

        $table->addForeignKeyConstraint(
            new Table($this->optionsTableName),
            [
                'option_id',
            ],
            [
                'option_id',
            ],
            [
                'onUpdate' => 'CASCADE',
                'onDelete' => 'CASCADE',
            ]
        );

        $table->addForeignKeyConstraint(
            new Table($this->attributesTableName),
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
                'option_id' => 'pim.entity_id',
                'attribute_id' => 'o.attribute_id',
                'attribute_code' => 'INSERT(pim.code, LOCATE(a.attribute_code, pim.code), LENGTH(a.attribute_code) + 1, "")',
            ])
            ->from($pimgentoTableName, 'pim')
            ->innerJoin('pim', $this->optionsTableName, 'o',
                $queryBuilder->expr()->eq('pim.entity_id', 'o.option_id'))
            ->innerJoin('o', $this->attributesTableName, 'a',
                $queryBuilder->expr()->eq('o.attribute_id', 'a.attribute_id'))
            ->where($queryBuilder->expr()->eq('pim.import', '?'))
        ;

        return $this->connection->executeUpdate(
            "INSERT INTO {$this->connection->quoteIdentifier($this->tableName)} "
                .$queryBuilder->getSQL(),
            [
                'option',
            ]
        );
    }
}
