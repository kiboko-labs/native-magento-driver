<?php
/**
 * Copyright (c) 2016 Kiboko SAS.
 *
 * @author Grégory Planchat <gregory@kiboko.fr>
 */

namespace Kiboko\Component\MagentoMapper\SchemaManager\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Schema\Comparator as SchemaComparator;

class AttributeOptionValueMappingSchemaManager extends AbstractMappingSchemaManager
{
    /**
     * @var string
     */
    private $attributeOptionValueTableName;

    /**
     * @var string
     */
    private $attributeOptionTableName;

    /**
     * OptionMappingSchemaManager constructor.
     *
     * @param Connection       $connection
     * @param SchemaComparator $schemaComparator
     * @param string           $tableName
     * @param string           $attributeOptionValueTableName
     * @param string           $attributeOptionTableName
     */
    public function __construct(
        Connection $connection,
        SchemaComparator $schemaComparator,
        $tableName,
        $attributeOptionValueTableName,
        $attributeOptionTableName
    ) {
        parent::__construct($connection, $schemaComparator, $tableName);
        $this->attributeOptionValueTableName = $attributeOptionValueTableName;
        $this->attributeOptionTableName = $attributeOptionTableName;
    }

    /**
     * @return Table
     */
    protected function declareTable()
    {
        $table = new Table($this->tableName);

        $table->addColumn('value_id', 'integer', [
            'unsigned' => true,
        ]);

        $table->addColumn('instance_identifier', 'string', [
            'length' => 64,
        ]);

        $table->addColumn('option_code', 'string', [
            'length' => 255,
        ]);

        $table->addColumn('locale', 'string', [
            'length' => 12,
        ]);

        $table->addColumn('mapping_class', 'string', [
            'length' => 255,
        ]);

        $table->addColumn('mapping_options', 'text');

        $table->addIndex(['value_id']);

        $table->addIndex(['option_code']);

        $table->addIndex(['locale']);

        $table->addUniqueIndex(['instance_identifier', 'value_id']);

        $table->addForeignKeyConstraint(
            $this->attributeOptionValueTableName,
            [
                'value_id',
            ],
            [
                'value_id',
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
     *
     * @return int|null
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function initializeFromPimgento($pimgentoTableName, $linkCode)
    {
        return null;
    }
}
