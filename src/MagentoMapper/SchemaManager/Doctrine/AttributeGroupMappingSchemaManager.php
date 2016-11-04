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

class AttributeGroupMappingSchemaManager extends AbstractMappingSchemaManager
{
    /**
     * @var string
     */
    private $attributeGroupsTableName;

    /**
     * OptionMappingSchemaManager constructor.
     *
     * @param Connection       $connection
     * @param SchemaComparator $schemaComparator
     * @param string           $tableName
     * @param string     $attributeGroupsTableName
     */
    public function __construct(
        Connection $connection,
        SchemaComparator $schemaComparator,
        $tableName,
        $attributeGroupsTableName
    ) {
        parent::__construct($connection, $schemaComparator, $tableName);
        $this->attributeGroupsTableName = $attributeGroupsTableName;
    }

    /**
     * @return Table
     */
    protected function declareTable()
    {
        $table = new Table($this->tableName);

        $table->addColumn('attribute_group_id', 'smallint', [
            'unsigned' => true,
        ]);

        $table->addColumn('instance_identifier', 'string', [
            'length' => 64
        ]);

        $table->addColumn('attribute_group_code', 'string', [
            'length' => 255,
        ]);

        $table->addColumn('family_code', 'string', [
            'length' => 255,
        ]);

        $table->addColumn('mapping_class', 'string', [
            'length' => 255,
        ]);

        $table->addColumn('mapping_options', 'text');

        $table->addIndex(['attribute_group_id']);

        $table->addIndex(['attribute_group_code']);

        $table->addIndex(['family_code']);

        $table->addUniqueIndex(['instance_identifier', 'attribute_group_id']);

        $table->addForeignKeyConstraint(
            $this->attributeGroupsTableName,
            [
                'attribute_group_id',
            ],
            [
                'attribute_group_id',
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
     * @return int|null
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
                'attribute_group_id' => 'pim.entity_id',
                'attribute_group_code' => 'pim.code',
            ])
            ->from($pimgentoTableName, 'pim')
            ->where($queryBuilder->expr()->eq('pim.import', $queryBuilder->expr()->literal('attribute_group')))
        ;

        return $this->connection->executeUpdate(
            "INSERT INTO {$this->connection->quoteIdentifier($this->tableName)} "
                .$queryBuilder->getSQL()
        );
    }
}
