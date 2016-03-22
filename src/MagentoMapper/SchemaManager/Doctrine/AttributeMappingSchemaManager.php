<?php

namespace Luni\Component\MagentoMapper\SchemaManager\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Schema\Table;
use Luni\Component\MagentoMapper\SchemaManager\MappingSchemaManagerInterface;

class AttributeMappingSchemaManager implements MappingSchemaManagerInterface
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
    private $attributesTableName;

    /**
     * OptionMappingSchemaManager constructor.
     *
     * @param Connection $connection
     * @param string     $tableName
     * @param string     $attributesTableName
     */
    public function __construct(
        Connection $connection,
        $tableName,
        $attributesTableName
    ) {
        $this->connection = $connection;
        $this->tableName = $tableName;
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

        $table->addColumn('attribute_id', 'smallint', [
            'unsigned' => true,
        ]);

        $table->addColumn('attribute_code', 'string', [
            'length' => 255,
        ]);

        $table->addIndex(['attribute_id']);

        $table->addIndex(['attribute_code']);

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

        $this->connection->executeQuery(
            "INSERT INTO {$this->connection->quoteIdentifier($this->tableName)} "
                .$queryBuilder->getSQL(),
            [
                'attribute',
            ]
        );
    }
}
